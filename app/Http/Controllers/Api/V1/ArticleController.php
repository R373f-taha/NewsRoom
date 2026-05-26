<?php

namespace App\Http\Controllers\Api\V1;

use App\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Article\CreateArticleRequest;
use App\Http\Resources\V1\ArticleResource;
use App\Http\Resources\V1\ArticleV1Resource;
use App\Models\Article;
use App\Services\V1\ArticleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    use ApiResponseTrait;
    protected $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;

    }
    /**
     * Display a listing of the resource.
     */
    public function all()
    {
        $articles = $this->articleService->all();

        return $this->successResponse(
            ArticleResource::collection($articles),
            'Articles with all details retrieved successfully 😊💛'
        );
    }
     public  function indexV1(){

    $articles=$this->articleService->index();

      if($articles->isEmpty())
          return $this->successResponse(
            ArticleV1Resource::collection($articles),
            'There are no published articles yet (version 1)😑😑'
        );

       return $this->successResponse(
            ArticleV1Resource::collection($articles),
            'Published articles (version 1) retrieved successfully 😊💛'
        );
     }
    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateArticleRequest $request)
    {
        $res=$this->articleService->create($request);

        return $this->successResponse(
            new ArticleResource($res),
            'Article created successfully 😊💛'
        );


    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return $this->successResponse(
            new ArticleResource($article),
            'Article with all details retrieved successfully'
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


}
