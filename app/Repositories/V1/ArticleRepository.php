<?php

namespace App\Repositories\V1;

use App\Action\V1\Article\CreateArticleAction;
use App\Contracts\Repositories\ArticleRepositoryInterface;
use App\Events\ArticlePublished;
use App\Http\Requests\Article\CreateArticleRequest;
use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Override;

class ArticleRepository implements ArticleRepositoryInterface
{

    public function all()
    {

    $cacheKey = 'all_articles_with_tags_author';

  return Cache::flexible($cacheKey, [300, 600], function () use ($cacheKey) {
        return Article::with(['tags', 'author'])->get();
    });

    }

public function find($id)
{
    $cacheKey = "article_{$id}_with_tags_author";

    return Cache::flexible($cacheKey, [300, 600], function () use ($id) {
        return Article::with(['tags', 'author'])->find($id);
    });
}

   #[Override]
    public function index()
    {
      $articles=Article::published()->withCount('comments')->get();

      return $articles;
    }

    public function create(CreateArticleRequest $data)
    {
        $data=$data->validated();


        $article = CreateArticleAction::execute($data);


        return $article;
    }
    public function publish(Article $article){

    $article->update(['status'=>'published']);

    $article->published_at=now();

    $article->save();

    ArticlePublished::dispatch($article);

    return $article->fresh(['tags','author']);

    }


    public function getDashboardStats()
    {
        $DashboardCacheKey='dashboard_stats';

        $stats=Cache::get($DashboardCacheKey);

        if($stats!==null){
            return $stats;
        }

        $lockKey = $DashboardCacheKey . '_lock';
        $lock=Cache::lock($lockKey, 15);

        try{

        if($lock->block(5)){

        $stats=Cache::get($DashboardCacheKey);

        if($stats!==null){
            $lock->release();
            return $stats;
        }

       $Dashboard=$this->calculateDashboardStats();
        Cache::put($DashboardCacheKey, $Dashboard, 600);

        $lock->release();
        return $Dashboard;

        }

        usleep(500000);
        $stats=Cache::get($DashboardCacheKey);
        Log::warning('Dashboard stats cache stampede fallback');
        if($stats!==null){
            return $stats;
        }

        return $this->calculateDashboardStats();


    }
    catch(\Exception $e){
        Log::error('Error acquiring dashboard stats lock: '.$e->getMessage());
        return $this->calculateDashboardStats();
    }
    }

    public function calculateDashboardStats()
    {
        $totalArticles = Article::count();
        $totalComments =Comment::count();
        $publishedArticles = Article::where('status', 'published')->count();
        $draftArticles = Article::where('status', 'draft')->count();
        $archivedArticles = Article::where('status', 'archived')->count();

        return [ 'total_articles' => $totalArticles,
            'total_comments' => $totalComments,
            'published_articles' => $publishedArticles,
            'draft_articles' => $draftArticles,
            'archived_articles' => $archivedArticles,
            'most_active_writers' => $this->getMostActiveWriters(5),
        ];
    }
    public function getMostActiveWriters($limit = 5)
    {
        return User::where('role', 'writer')
            ->withCount([
                'articles'=> function($query){
                    $query->where('status','published');
                },
             'comments'])
            ->having('articles_count','>',0)
            ->orderByRaw('(articles_count + comments_count) DESC')
            ->take($limit)
            ->get()->map(function($writer){
                return [
                    'id'=>$writer->id,
                    'name'=>$writer->name,
                    'email'=>$writer->email,
                    'published_articles'=>$writer->articles_count,
                    'comments_count'=>$writer->comments_count,
                    'total_interactions'=>$writer->articles_count + $writer->comments_count
                ];
            });
    }
    public function cacheClear($id = null)
    {
        if ($id) {
            Cache::forget("article_{$id}_with_tags_author");
        } else {
            Cache::forget('all_articles_with_tags_author');
        }
    }

    public function cacheDashboardStatsClear()
    {
        Cache::forget('dashboard_stats');
    }



}
