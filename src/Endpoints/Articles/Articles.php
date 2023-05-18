<?php

declare(strict_types = 1);

namespace RonildoSousa\DevtoForLaravel\Endpoints\Articles;

use Illuminate\Support\Collection;
use RonildoSousa\DevtoForLaravel\Contracts\ArticleEndpointInterface;
use RonildoSousa\DevtoForLaravel\Endpoints\BaseEndpoint;
use RonildoSousa\DevtoForLaravel\Entities\Article;
use RonildoSousa\DevtoForLaravel\Enums\HttpMethod;
use RonildoSousa\DevtoForLaravel\Traits\{HasFilterByLatest, HasFilterByTags, HasFilterByUserArticles, HasFilterByUsername, HasItemsPerPage};
use Symfony\Component\HttpFoundation\Response;

class Articles extends BaseEndpoint implements ArticleEndpointInterface
{
    use HasItemsPerPage;
    use HasFilterByUserArticles;
    use HasFilterByTags;
    use HasFilterByUsername;
    use HasFilterByLatest;

    private const URI_PROPERTIES = [
        'latest', 'me', 'published', 'unpublished',
    ];

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

    public function create(array $payload): Article|Collection
    {
        $response = $this->request(HttpMethod::POST, '/articles', ['article' => $payload]);

        if ($response->status() !== Response::HTTP_OK) {
            return $response->collect();
        }

        return new Article($response->collect()->toArray());
    }

    public function update(int $id, array $payload): Article|Collection
    {
        $response = $this->request(HttpMethod::PUT, "/articles/{$id}", ['article' => $payload]);

        if ($response->status() !== Response::HTTP_OK) {
            return $response->collect();
        }

        return new Article($response->collect()->toArray());
    }

    public function find(int $id): Article|Collection
    {
        $response = $this->request(HttpMethod::GET, "/articles/{$id}");

        if ($response->status() !== Response::HTTP_OK) {
            return $response->collect();
        }

        return new Article($response->collect()->toArray());
    }

    public function get(): Collection
    {
        $propertiesUri = collect(self::URI_PROPERTIES)
            ->filter(fn ($value) => $this->$value)
            ->map(fn ($value) => ($this->me && !$this->published && !$this->unpublished) ? "{$this->me}/all" : $value)
            ->implode('/');

        $prefix = '/articles' . ($propertiesUri ? "/$propertiesUri" : '');

        $uri = $this->makeUri($prefix, self::URI_PROPERTIES);

        $response = $this->request(HttpMethod::GET, $uri);

        if ($response->status() !== Response::HTTP_OK) {
            return $response->collect();
        }

        return $this->transform($response->collect(), Article::class);
    }

    private function makeUri(string $prefix = '', array $uriParams = []): string
    {
        $queryParams = collect(get_object_vars($this))
            ->filter(fn ($value, $key) => !in_array($key, $uriParams) && !blank($value))
            ->toArray();

        $query = http_build_query($queryParams);

        return "{$prefix}?{$query}";
    }
}
