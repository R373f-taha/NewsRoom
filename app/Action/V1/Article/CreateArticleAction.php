<?php

namespace App\Action\V1\Article;

use App\Models\Article;

class CreateArticleAction{

public static function execute(array $data){

$articleData=[
    'title'=>$data['title'],
    'content'=>$data['content'],
    'author_id'=>$data['author_id'],
    'status'=>$data['status'],
    'reviewer_id'=>$data['reviewed_id'] ?? null ,
    'published_at'=>$data['published_at'] ?? null

];

$article=Article::create($articleData);

if(!empty($data['tags'])){
$article->tags()->attach($data['tags']);
}

return $article->load('tags','author');
}
}
