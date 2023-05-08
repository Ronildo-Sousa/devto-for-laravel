<?php

declare(strict_types = 1);

namespace RonildoSousa\DevtoForLaravel\Endpoints\Articles;

use Illuminate\Support\Collection;
use RonildoSousa\DevtoForLaravel\Endpoints\BaseEndpoint;
use RonildoSousa\DevtoForLaravel\Entities\Article;

class Articles extends BaseEndpoint
{
    public function get(): Collection
    {
        $articles = $this->service
            ->api
            ->get('/articles')
            ->collect();

        return $this->transform($articles, Article::class);
    }
}
