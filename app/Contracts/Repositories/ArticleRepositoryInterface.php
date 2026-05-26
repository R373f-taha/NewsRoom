<?php

namespace App\Contracts\Repositories;

use App\Http\Requests\Article\CreateArticleRequest;
use App\Models\Article;

interface ArticleRepositoryInterface
{
    public function all();
    public function find($id);

    public function create(CreateArticleRequest $data);

    public function cacheClear($id=null);

    public function getDashboardStats();

    public function getMostActiveWriters($limit=5);

     public function calculateDashboardStats();
     public function cacheDashboardStatsClear();

     public function index();

     public function publish(Article $article);
}
