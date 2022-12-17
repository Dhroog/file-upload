<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class FileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = new User();
        $user1->username = 'admin';
        $user1->is_admin = true;
        $user1->email = 'admin@gmail.com';
        $user1->email_verified_at = now();
        $user1->email_verify_code_sent_at = now()->addMinutes(15);
        $user1->password = 123456;
        $user1->save();

        $user2 = new User();
        $user2->username = 'user';
        $user2->is_admin = false;
        $user2->email = 'user@gmail.com';
        $user2->email_verified_at = now();
        $user2->email_verify_code_sent_at = now()->addMinutes(15);
        $user2->password = 123456;
        $user2->save();
    }
}
