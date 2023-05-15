<?php

declare(strict_types = 1);

namespace RonildoSousa\DevtoForLaravel\Endpoints\Articles;

use Illuminate\Support\Collection;
use RonildoSousa\DevtoForLaravel\Endpoints\BaseEndpoint;
use RonildoSousa\DevtoForLaravel\Entities\Article;
use Symfony\Component\HttpFoundation\Response;

class Articles extends BaseEndpoint
{
    private int $per_page = 30;

    private string $username = "";

    private ?int $page = null;

    private string $latest = '';

    private string $me = '';

    private string $published = '';

    private string $unpublished = '';

    private string $tags = '';

    private string $tags_exclude = '';

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

    public function publish(int $id): Article|Collection
    {
        return $this->update($id, [
            'published' => true,
        ]);
    }

    public function unpublish(int $id): Article|Collection
    {
        return $this->update($id, [
            'published' => false,
        ]);
    }

    public function published(): static
    {
        $this->published = 'published';

        return $this;
    }

    public function unpublished(): static
    {
        $this->unpublished = 'unpublished';

        return $this;
    }

    public function me(): static
    {
        $this->me = 'me';

        return $this;
    }

    public function latest(): static
    {
        $this->latest = 'latest';

        return $this;
    }

    public function fromPage(int $page): static
    {
        $this->page = $page;

        return $this;
    }

    public function from(string $name): static
    {
        $this->username = $name;

        return $this;
    }

    public function withoutTags(array $tags): static
    {
        $this->tags_exclude = implode(',', $tags);

        return $this;
    }

    public function withTags(array $tags): static
    {
        $this->tags = implode(',', $tags);

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
        $propertiesExclude = ['latest', 'me', 'published', 'unpublished', 'service'];
        $propertiesPath    = '';
        $propertiesPath .= collect($propertiesExclude)
            ->filter(fn ($value) => $this->$value && $value !== 'service')
            ->map(fn ($value) => ($this->me && !$this->published && !$this->unpublished) ? "{$this->me}/all" : $value)
            ->implode('/');

        $prefix = '/articles' . ($propertiesPath ? "/$propertiesPath" : '');

        $uri = $this->makeUri($prefix, $propertiesExclude);

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

    private function makeUri(string $prefix = '', array $withouProperties = []): string
    {
        $classProperties = get_class_vars(__CLASS__);
        $classProperties = collect($classProperties)
            ->filter(fn ($value, $key) => !in_array($key, $withouProperties))
            ->map(fn ($value, $key) => $this->$key)
            ->filter(fn ($value) => $value);

        $query = http_build_query($classProperties->toArray());

        return "{$prefix}?{$query}";
    }
}
