<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $posts = \App\Models\Post::all();

         $users = \App\Models\User::all();

         if($posts->count() == 0){
             $this->command->info("please create some posts !");
             return;
         }
         $nbComments =(int) $this->command->ask("How many of comment you want generate ?",80);
         Comment::factory()->count($nbComments)->make()->each(function($comment) use ($posts,$users){
             $comment->post_id = $posts->random()->id;
             $comment->user_id = $users->random()->id;
             $comment->save();
         });
    }
}
