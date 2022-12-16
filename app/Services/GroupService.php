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
        $group = Group::create($data);
        $group->users()->attach(auth()->id() , ['is_owner' => true]);
        return $this->normalize($group,GroupResource::class);
    }

    public function addUserToGroup(Group $group,User $user)
    {
        abort_if(!$this->UserOwnerGroup(auth()->user(),$group),400,'user not join for this group');
        $group->users()->attach($user->id);
        return $this->normalize($group,GroupResource::class);
    }

    public function deleteUserFromGroup(Group $group,User $user)
    {
        abort_if(!$this->UserOwnerGroup(auth()->user(),$group),400,'user not have  this group');

        $files =  $group->files;
        foreach ($files as $file){
            if($file->check_in){
                abort_if($file->log->first()->user_id == $user->id,400,'user check-in some files ');
            }
        }
        $group->users()->detach($user->id);
        abort(200,'User has Deleted ');
        return $this->normalize($group,GroupResource::class);
    }

    public function Delete($group)
    {
        abort_if(!$this->UserOwnerGroup(auth()->user(),$group),400,'user not have  this group');
        $files = $group->files;
        foreach ($files as $file){
            abort_if($file->check_in,400,'there files check-in');
        }
        abort(200,'group has Deleted');
    }

    public function GetGroupsForUser()
    {
        //Cache::forget('key');
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
        return $this->normalizeList($files,UserResource::class);

    }

    public function UserOwnerGroup($user,Group $group)
    {
        return $user->groupsOwner->contains('id', $group->id);
    }


}
