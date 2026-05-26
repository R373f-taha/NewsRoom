<?php

namespace App\Repositories\V1;

use App\Contracts\Repositories\TagRepositoryInterface ;
use App\Models\Tag;
use Illuminate\Support\Facades\Cache;

class TagRepository  implements TagRepositoryInterface
{
    public function getTopTags($limit=10){

      return  Cache::remember("top_tags",now()->addDay(),function() use ($limit){

       return Tag::withCount('articles')->orderBy('articles_count','desc')->take($limit)->get();
       });
    }

    public function getTopTagsClearCache(){

        Cache::forget("top_tags");
    }
}
