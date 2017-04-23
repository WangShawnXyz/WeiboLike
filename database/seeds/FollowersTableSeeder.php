<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class FollowersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $user = $users->first();
        $user_id = $user->id;

        //get all users except a user who id = 1
        $followers = $users->slice(1);
        $follower_ids = $followers->pluck('id')->toArray();

        //id=1 user follow all user except itself
        $user->follow($follower_ids);

        //all users except id=1 follow id=1 user
        foreach ($followers as $follower) {
        	$follower->follow($user_id);
        }
    }
}
