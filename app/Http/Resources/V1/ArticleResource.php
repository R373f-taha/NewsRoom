<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author_name'=>$this->author?->name,
            'content' => $this->content,
            'status' => $this->status,
            'author' => new UserResource($this->whenLoaded('author')),
            'reviewer' => new UserResource($this->whenLoaded('reviewer')),
            'attachments' => AttachmentResource::collection($this->whenLoaded('attachments')),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
