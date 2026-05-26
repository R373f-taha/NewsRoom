<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Attachment;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttachmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users=User::all();
        $articles=Article::all();

        foreach($articles as $article){

            $randomAttachments=rand(1,10);
            Attachment::factory()->count($randomAttachments)->make()->each(function($attachment) use ($users,$article){
              
                $attachment->attachable_id=$article->id;
                $attachment->attachable_type=Article::class;
                $attachment->save();
            });
        }
    }
}
