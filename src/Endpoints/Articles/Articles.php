<?php

declare(strict_types=1);

namespace RonildoSousa\DevtoForLaravel\Endpoints\Articles;

use Illuminate\Support\Collection;
use RonildoSousa\DevtoForLaravel\Endpoints\BaseEndpoint;
use RonildoSousa\DevtoForLaravel\Entities\Article;

class Articles extends BaseEndpoint
{
    public int $per_page = 30;

    public function perPage(int $per_page): static
    {
        $this->per_page = $per_page;

        return $this;
    }

    public function get(): Collection
    {
        $uri = sprintf(
            '/articles?per_page=%d',
            $this->per_page
        );

        $articles = $this->service
            ->api
            ->get($uri)
            ->collect();

        return $this->transform($articles, Article::class);
    }
}
