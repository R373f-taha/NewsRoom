<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\V1\TagService;
use Illuminate\Http\Request;

class TagController extends Controller
{
    protected TagService $tagService;

public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }


    public function topTags($limit=10)
    {
      
        $tags = $this->tagService->getTopTags($limit);

        return response()->json([
            'success' => true,
            'data' => $tags,
            'message' => 'Top tags retrieved successfully 📈💛'
        ]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
