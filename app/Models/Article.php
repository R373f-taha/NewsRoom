<?php

namespace App\Models;

use App\Repositories\V1\ArticleRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Article extends Model
{
    use HasFactory ;
    protected $fillable = ['title','content','author_id','published_at',
    'reviewer_id','status'];



protected $casts = [
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
    'published_at'=>'datetime'
];
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function author(){

    return $this->belongsTo(User::class,'author_id');
    }
    public function reviewer(){

        return $this->belongsTo(User::class,'reviewer_id');
    }

    public function attachments(){

        return $this->morphMany(Attachment::class, 'attachable');
    }
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function getAuthorNameAttribute():string{

    return $this->author?->name ??'Unknown Author';

    }

   public function getReviewerNameAttribute():string{

    return $this->reviewer?->name ??'Unknown Reviewer';

    }
    public function scopePublished($query){

    return $query->where('status','published')->where('published_at','!=',null);

    }

    public function getReadingTimeAttribute():int{

     $wordCount=str_word_count(strip_tags($this->content));
     $minutes=ceil($wordCount/200);

     return max(1,$minutes);



    }

    public function scopeDraft($query){

          return $query->withoutGlobalScopes()->where('status','draft');
    }

    public function scopeDraftOlderThanDays($query,$days=30){

    return $query->where('created_at','<',now()->subDays($days));
    }



    protected static function booted()
    {
        parent::booted();

        static::created(function ($article) {

            $repo=app(ArticleRepository::class);
            $repo->cacheDashboardStatsClear();
            $repo->cacheClear();

        });

        static::updated(function ($article) {
            $repo=app(ArticleRepository::class);
           $repo->cacheDashboardStatsClear();
            $repo->cacheClear($article->id);
             $repo->cacheClear();

        });

        static::deleted(function ($article) {
            $repo=app(ArticleRepository::class);
            $repo->cacheDashboardStatsClear();
            $repo->cacheClear($article->id);
            $repo->cacheClear();

        });

        static::addGlobalScope('visibility', function ($query) {

        $user=Auth::user();

            if(!$user){
                $query->where('status', 'published');
            }
              elseif($user->role==='admin'){


                    }

                       else if ($user->role === 'writer') {
                            $query->where(function ($q) use ($user) {
                                $q->where('status', 'published')
                                ->orWhere('author_id', $user->id);
                            });
                            return;
                        }
                    else{
                    $query->where(function ($q) use ($user) {
                        $q->where('status', 'published');
                            // ->orWhere('author_id', $user->id)
                            // ->orWhere('reviewer_id', $user->id);
                    });
                }
        });
    }
}
