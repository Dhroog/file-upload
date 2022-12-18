<?php


namespace App\Services;


use App\Http\Resources\FileResource;
use App\Http\Resources\FileResourceN;
use App\Http\Resources\GroupResource;
use App\Http\Resources\UserResource;
use App\Models\Group;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class GroupService extends BaseService
{

    public function store($data)
    {
        db::transaction(function () use ($data,&$group) {
            $group = Group::create($data);
            $group->users()->attach(auth()->id() , ['is_owner' => true]);
        });
        abort_if(!$group,400,'failed');
        return $this->normalize($group,GroupResource::class);
    }

    public function addUserToGroup(Group $group,User $user)
    {
        abort_if(!$this->UserOwnerGroup(auth()->user(),$group),400,"user can't add other to this group");
        $users = $group->users;

            abort_if( $users->contains('id', $user->id) ,400,'user already join to this group');
        $group->users()->attach($user->id);
        return $this->normalize($group,GroupResource::class);
    }

    public function deleteUserFromGroup(Group $group,User $user)
    {
        abort_if(!$this->UserOwnerGroup(auth()->user(),$group),400,'user not have  this group');

        db::transaction(function () use (&$group,$user) {
            $files =  $group->files;
            foreach ($files as $file){
                if($file->check_in){
                    abort_if($file->log->first()->user_id == $user->id,400,'user check-in some files ');
                }
            }
            $group->users()->detach($user->id);
            abort(200,'User has Deleted ');
        });
        return $this->normalize($group,GroupResource::class);
    }

    public function Delete($group)
    {
        abort_if(!$this->UserOwnerGroup(auth()->user(),$group),400,'user not have  this group');
        db::transaction(function () use ($group){
            $files = $group->files;
            foreach ($files as $file){
                abort_if($file->check_in,400,'there files check-in');
            }
            $group->delete;
            abort(200,'group has Deleted');
        });

    }

    public function GetGroupsForUser()
    {
        db::transaction(function () use (&$files){
            Cache::flush();
            if(request()->get('filter') == 'owner'){
                $files = Cache::rememberForever(auth()->id().'ownerGroup', function () {
                    return User::with('groupsOwner.files')
                        ->where('id',auth()->id())->get();
                });
            }
            else {
                $files = Cache::rememberForever(auth()->id().'allGroup', function () {
                    return User::with('groups.files')
                        ->where('id',auth()->id())->get();
                });
            }
        });
        abort_if(!$files,400,'failed');
        return $this->normalizeList($files,UserResource::class);
        //Cache::forget('key');
    }

    public function UserOwnerGroup($user,Group $group)
    {
        return $user->groupsOwner->contains('id', $group->id);
    }

    public function GetAllGroup()
    {
        //abort_if(!auth()->user()->is_admin,400,'user not have permission');
         $data = Group::with('files')->get();
        return $this->normalizeList($data,GroupResource::class);
    }



}
