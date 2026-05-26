<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Attachment;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users=User::all();

        Article::factory()->count(50)->create()->each(function($article) {

        // Comment::factory()->count(rand(2,5))->create([
        //     'commentable_type'=>Article::class,
        //     'commentable_id'=>$article->id
        // ]);

        // Attachment::factory(rand(2,5))->create([
        //     'attachable_type'=>Article::class,
        //     'attachable_id'=>$article->id
        // ]);

        $randomTags=Tag::inRandomOrder()->take(rand(1,5))->get();

      $article->tags()->attach($randomTags);
        });
    }
}
