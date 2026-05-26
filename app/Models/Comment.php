<?php

namespace App\Models;

use App\Repositories\V1\ArticleRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];

    use HasFactory;
    public function commentable(){

    return $this->morphTo();
    }

    public function  writer(){
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    protected static function booted()
    {
        parent::booted();

        static::created(function () {

            $repo=app(ArticleRepository::class);
            $repo->cacheDashboardStatsClear();


        });

        static::updated(function () {
            $repo=app(ArticleRepository::class);
           $repo->cacheDashboardStatsClear();

        });

        static::deleted(function () {
            $repo=app(ArticleRepository::class);
            $repo->cacheDashboardStatsClear();


        });}
}
