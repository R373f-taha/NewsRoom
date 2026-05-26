<?php

namespace App\Services\V1;

use App\Contracts\Repositories\TagRepositoryInterface;

class TagService
{
    protected TagRepositoryInterface $tagRepository;

    public function __construct(TagRepositoryInterface $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function getTopTags($limit=10)
    {
        return $this->tagRepository->getTopTags($limit);
    }

    public function getTopTagsClearCache()
    {
        return $this->tagRepository->getTopTagsClearCache();
    }
}
