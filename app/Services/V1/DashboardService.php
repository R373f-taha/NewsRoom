<?php

namespace App\Services\V1;

use App\Contracts\Repositories\ArticleRepositoryInterface;

class DashboardService{
  public function __construct(protected ArticleRepositoryInterface $articleRepository)
    {

    }
 public function getDashboardStats()
        {
            return $this->articleRepository->getDashboardStats();
        }

    public function clearDashboardStatsCache()
    {
        $this->articleRepository->cacheDashboardStatsClear();
    }

     public function getMostActiveWriters($limit=5)
    {
        return $this->articleRepository->getMostActiveWriters($limit);
    }


}
