<?php

namespace App\Services\V1;

use App\Contracts\Repositories\ArticleRepositoryInterface;
use App\Http\Requests\Article\CreateArticleRequest;
use App\Models\Article;

class ArticleService
{
    // protected ArticleRepositoryInterface $articleRepository;
  public function __construct(protected ArticleRepositoryInterface $articleRepository)
    {

    }

    public function index(){

    $articles=$this->articleRepository->index();

    return $articles;
    }

    public function all()
    {
        return $this->articleRepository->all();
    }

    public function find($id)
    {
        return $this->articleRepository->find($id);
    }

    public function create(CreateArticleRequest $request)
    {
        return $this->articleRepository->create($request);
    }

    public function publish(Article $article){

    if($article->status!=='draft')

        return ['article'=>$article,'message'=>'Article isn`t draft'];


     return $this->articleRepository->publish($article);

    }

    public function cacheClear($id = null)
    {
        $this->articleRepository->cacheClear($id);
    }
}
