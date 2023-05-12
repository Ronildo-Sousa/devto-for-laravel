<?php

declare(strict_types=1);

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

    private string $return_me = '';

    private string $return_published = '';

    private string $return_unpublished = '';

    private int $per_page = 30;

    private array $tags_include = [];

    private array $tags_exclude = [];

    public function create(array $payload): Article|Collection
    {
        $response = $this->service
            ->api->post('/articles', ['article' => $payload]);

        $status   = $response->status();
        $response = $response->collect();

        if ($status !== Response::HTTP_OK) {
            return $response;
        }

        return new Article($response->toArray());
    }

    public function unpublish(int $id): Article|Collection
    {
        return $this->update($id, [
            'published_at'          => null,
            'published_timestamp'   => '',
            'readable_publish_date' => null,
        ]);
    }

    public function published(): static
    {
        $this->return_published = '/published';

        return $this;
    }

    public function unpublished(): static
    {
        $this->return_unpublished = '/unpublished';

        return $this;
    }

    public function me(): static
    {
        $this->return_me = '/me';

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

    public function update(int $id, array $payload): Article|Collection
    {
        $response = $this->service
            ->api
            ->put("/articles/{$id}", ['article' => $payload]);

        $status   = $response->status();
        $response = $response->collect();

        if ($status !== Response::HTTP_OK) {
            return $response;
        }

        return new Article($response->toArray());
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

        $getMe = $this->getMeUri();

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

    private function getMeUri(): ?string
    {
        if ($this->return_me) {
            if ($this->return_published) {
                return $this->return_me . $this->return_published;
            }

            if ($this->return_unpublished) {
                return $this->return_me . $this->return_unpublished;
            }

            return $this->return_me . '/all';
        }

        return null;
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
