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

    public function withoutTags(array $tags): static
    {
        $this->tags_exclude = $tags;

        return $this;
    }

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
        $articles = $this->service
            ->api
            ->get($this->makeUri('/articles'))
            ->collect();

        return $this->transform($articles, Article::class);
    }

    private function makeUri(string $prefix = ''): string
    {
        $uri = "{$prefix}?";
        $i   = 0;

        $properties = [
            'per_page'     => $this->per_page,
            'tags'         => $this->tags_include,
            'tags_exclude' => $this->tags_exclude,
        ];

        foreach ($properties as $key => $value) {
            if (empty($value) || $value == "") {
                continue;
            }

            if (is_array($value)) {
                $value = implode(',', $value);
            }
            $uri .= (($i !== 0) ? '&' : '') . "{$key}={$value}";

            $i++;
        }

        return $uri;
    }
}
