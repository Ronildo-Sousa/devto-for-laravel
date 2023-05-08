<?php

declare(strict_types = 1);

namespace RonildoSousa\DevtoForLaravel\Endpoints\Articles;

use Illuminate\Support\Collection;
use RonildoSousa\DevtoForLaravel\Endpoints\BaseEndpoint;
use RonildoSousa\DevtoForLaravel\Entities\Article;

class Articles extends BaseEndpoint
{
    private int $per_page = 30;

    private array $tags_include = [];

    private array $tags_exclude = [];

    public function withTags(array $tags): static
    {
        $this->tags_include = $tags;

        return $this;
    }

    public function perPage(int $per_page): static
    {
        $this->per_page = $per_page;

        return $this;
    }

    public function get(): Collection
    {
        $uri = sprintf(
            '/articles?per_page=%d&tags=%s',
            $this->per_page,
            implode(',', $this->tags_include)
        );

        $articles = $this->service
            ->api
            ->get($uri)
            ->collect();

        return $this->transform($articles, Article::class);
    }
}
