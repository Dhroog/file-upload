<?php


namespace App\Services;


use App\Http\Resources\FileResource;
use App\Http\Resources\FileResourceN;
use App\Jobs\loggingFile;
use App\Models\File;
use App\Models\Group;
use App\Services\UploadService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class FileService extends BaseService
{

    public function store($data)
    {
        $file = null;
        db::transaction(function () use ($data,&$file) {
            //get file from request
            $file = request()->file('file');
            if(!$file) abort(400,'failed upload file');
            //get group from database
            $group = Group::find($data['group_id']);
            //check if group contain this file
            if($this->FileInGroup($file->getClientOriginalName(),$group))
                abort(400,'file already in this group');
            //store file on server
            $uploadService = new UploadService();
            $file = $uploadService->file($file);
            //store file in database
            //$attributes = ['user_id' => auth()->id()] + $file->toArray();
            $file = auth()->user()->files()->create($file->toArray());
            $group->files()->attach($file->id);
        });
        abort_if(!$file,400,'failed');
        $file->refresh();
        return $this->normalize($file,FileResource::class);
    }

    public function addFileToGroup(File $file,Group $group)
    {
        db::transaction(function () use ($file,$group) {
            if(!$this->UserInGroup(auth()->user(),$group))
                abort(400,'user not join for this group');
            if($this->FileInGroup($file->file_name,$group))
                abort(400,'file already in this group');
            if($file->check_in) abort(400,'file check-in ');
            $group->files()->attach($file->id);

        });
        return $this->normalize($file,FileResource::class);
    }

    public function CheckIn($data){
        $files1 = File::findOrfail($data['ids']);
        db::transaction(function () use ($data,&$files1) {
            $files = DB::table('users')
                ->join('group_users','users.id','=','group_users.user_id')
                ->join('groups','group_users.group_id','=','groups.id')
                ->join('file_groups','file_groups.group_id','=','groups.id')
                ->join('files','file_groups.file_id','=','files.id')
                ->where('users.id','=',auth()->id())
                ->whereIn('files.id',$data['ids'])
                ->select('files.*')
                ->get();
            if( $files->contains('check_in' ,true) )
                abort(400,'there files check-in');
            if( $files->count() < count($data['ids']) )
                abort(400,'user cant check-in for this files');

            foreach ($files1 as $file){
                $file->update(['check_in' => true]);
                loggingFile::dispatch(
                    auth()->id(),
                    auth()->user()->username,
                    $file->id,
                    'check-in'
                );
            }
        });
        return $this->normalizeList($files1,FileResource::class);


    }

    public function CheckOut(File $file)
    {

        db::transaction(function () use (&$file) {
            abort_if(!$file->check_in,400,'file not check-in');
            $log = $file->log->first();
            abort_if(
                $log->user_id != auth()->id() || $log->change != 'check-in',
                400,"this file check-in");
            $file->update(['check_in' => false]);
            loggingFile::dispatch(
                auth()->id(),
                auth()->user()->username,
                $file->id,
                'check-out'
            );

            //store file on server
            $uploadService = new UploadService();
            $fileNEW = request()->file('file');
            $fileNEW = $uploadService->file($fileNEW);
            $fileNEW->originalName = $file->file_name;
            $file->update($fileNEW->toArray());
        });
        return $this->normalize($file,FileResource::class);

    }

    public function GetFileForRead(File $file)
    {

        db::transaction(function () use (&$file) {
            abort_if($file->check_in,400,"file check-in");
            $files = DB::table('users')
                ->join('group_users','users.id','=','group_users.user_id')
                ->join('groups','group_users.group_id','=','groups.id')
                ->join('file_groups','file_groups.group_id','=','groups.id')
                ->join('files','file_groups.file_id','=','files.id')
                ->where('users.id','=',auth()->id())
                ->where('files.id','=',$file->id)
                ->select('files.*')
                ->get();
            abort_if($files->count() == 0,400,"user can't get this file");
        });
        return $this->normalize($file,FileResource::class);

    }

    public function DeleteFile(File $file)
    {
        abort_if($file->check_in,400,'File check-in');

            $file->delete();

        return $this->normalize($file,FileResource::class);
    }

    public function FileInGroup($file_name,Group $group)
    {
        return $group->files->contains('file_name', $file_name);
    }

    public function GetFilesForUser()
    {
        $files = auth()->user()->files;
        return $this->normalizeList($files,FileResourceN::class);
    }

    public function FileHistory(File $file)
    {
        return $file->log;
    }

    public function UserInGroup($user,Group $group)
    {
        return $group->users->contains('username', $user->username);
    }
}
