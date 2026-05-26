<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $users=User::all();
         $articles=Article::all();


    foreach($articles as $article){

    $randomComments=rand(1,8);
          Comment::factory()->count($randomComments)->make()->each(function($comment) use ($users,$article){
                $comment->writer_id=$users->random()->id;
                $comment->commentable_id=$article->id;
                $comment->commentable_type=Article::class;
                $comment->save();
          });
    }}
}
