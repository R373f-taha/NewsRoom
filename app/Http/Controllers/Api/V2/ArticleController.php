<?php

namespace App\Http\Controllers\Api\V2;

use App\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\V2\ArticleV2Resource;
use App\Models\Article;
use App\Services\V1\ArticleService;
use Illuminate\Http\Request;

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

   public  function indexV2(){

     $articles=$this->articleService->index()->load(['tags']) ;

      if($articles->isEmpty())
          return $this->successResponse(
            ArticleV2Resource::collection($articles),
            'There are no published Articles yet (version 2)😑😑'
        );

       return $this->successResponse(
            ArticleV2Resource::collection($articles),
           'Published Articles (version 2) retrieved successfully 😊💛'
        );
     }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
