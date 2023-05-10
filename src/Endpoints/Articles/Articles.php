<?php

declare(strict_types = 1);

namespace RonildoSousa\DevtoForLaravel\Endpoints\Articles;

use Illuminate\Support\Collection;
use RonildoSousa\DevtoForLaravel\Endpoints\BaseEndpoint;
use RonildoSousa\DevtoForLaravel\Entities\Article;
use Symfony\Component\HttpFoundation\Response;

class Articles extends BaseEndpoint
{
    private string $from = "";

    private ?int $page = null;

    private bool $return_latest = false;

    private bool $return_me = false;

    private bool $return_published = false;

    private bool $return_unpublished = false;

    private int $per_page = 30;

    private array $tags_include = [];

    private array $tags_exclude = [];

    public function me(): static
    {
        $this->return_me = true;

        return $this;
    }

    public function latest(): static
    {
        $this->return_latest = true;

        return $this;
    }

    public function fromPage(int $page): static
    {
        $this->page = $page;

        return $this;
    }

    public function from(string $name): static
    {
        $this->from = $name;

        return $this;
    }

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

    public function find(int $id): Article|Collection
    {
        $response = $this->service
            ->api
            ->get("/articles/{$id}");

        $status   = $response->status();
        $response = $response->collect();

        if ($status !== Response::HTTP_OK) {
            return $response;
        }

        return new Article($response->toArray());
    }

    public function get(): Collection
    {
        $getLatest = ($this->return_latest) ? '/latest' : '';

        $getPublished   = ($this->return_published) ? '/published' : null;
        $getUnpublished = ($this->return_unpublished) ? '/unpublished' : null;
        $getMe          = ($this->return_me) ? '/me/all' . ($getPublished ? $getPublished : $getUnpublished) : '';

        $uri = $this->makeUri("/articles{$getLatest}{$getMe}");

        $response = $this->service
            ->api
            ->get($uri);

        $status   = $response->status();
        $response = $response->collect();

        if ($status !== Response::HTTP_OK) {
            return $response;
        }

        return $this->transform($response, Article::class);
    }

    private function makeUri(string $prefix = ''): string
    {
        $uri = "{$prefix}?";
        $i   = 0;

        $properties = [
            'per_page'     => $this->per_page,
            'tags'         => $this->tags_include,
            'tags_exclude' => $this->tags_exclude,
            'username'     => $this->from,
            'page'         => $this->page,
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
