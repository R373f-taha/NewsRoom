<?php

namespace App\Contracts\Repositories;

interface TagRepositoryInterface{

public function getTopTags($limit=10);

 public function getTopTagsClearCache();
 
}
