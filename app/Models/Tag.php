<?php

namespace App\Models;

use App\Repositories\V1\TagRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function articles()
    {
        return $this->morphedByMany(Article::class, 'taggable');
    }

    public function comments()
    {
        return $this->morphedByMany(Comment::class, 'taggable');
    }

    protected static function booted(){

      parent::booted();

      static::created(function($tag){
        $repo=app(TagRepository::class);
        $repo->getTopTagsClearCache();

      });

        static::updated(function($tag){
        $repo=app(TagRepository::class);
        $repo->getTopTagsClearCache();

      });
        static::deleted(function($tag){
        $repo=app(TagRepository::class);
        $repo->getTopTagsClearCache();

      });
    
    }
}
