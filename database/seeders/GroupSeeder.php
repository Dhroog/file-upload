<?php

namespace Database\Seeders;

use App\Models\File;
use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::factory(25)
            ->hasAttached(Group::factory(3),['is_owner'=>true])
            ->has(File::factory(5))
            ->create();
        foreach ($users as $user){
            $files = $user->files;
            $groups = $user->groups;
            foreach ($files as $file){
                foreach ($groups as $group){
                    $group->files()->attach($file->id);
                }
            }
        }
    }
}
