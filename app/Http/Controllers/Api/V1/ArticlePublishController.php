<?php
namespace App\Http\Controllers\Api\V1;

use App\ApiResponseTrait;
use App\Http\Resources\V1\ArticleResource;
use App\Models\Article;
use App\Services\V1\ArticleService;
use Illuminate\Support\Facades\Auth;

class ArticlePublishController{


    use ApiResponseTrait;
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;

    }

      public  function publish(Article $article){


     if(Auth::user()->id !==$article->author_id){

     return $this->errorResponse('this article is not for you😒😒', 403);

   }

    $res=$this->articleService->publish($article);

        return $this->successResponse(
            new ArticleResource($article),
            'Article published successfully✅'
        );



    }

}
