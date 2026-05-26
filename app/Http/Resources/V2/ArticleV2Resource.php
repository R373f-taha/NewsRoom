<?php

namespace App\Http\Resources\V2;

use App\Http\Resources\V1\AttachmentResource;
use App\Http\Resources\V1\TagResource;
use App\Http\Resources\V1\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleV2Resource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
   {

        return  [
            'id' => $this->id,
            'title' => $this->title,
            'author_name'=>$this->author?->name,
            'content' => $this->content,
            'published_at'=>$this->published_at?->format('Y-m-d H:i:s'),
            'reading_time'=>$this->reading_time,
            'comments_count'=>$this->whenCounted('comments'),
             'tags' => TagResource::collection($this->whenLoaded('tags')),

            ];
    }
}
