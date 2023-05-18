<?php

declare(strict_types = 1);

namespace RonildoSousa\DevtoForLaravel\Endpoints\Articles;

use Illuminate\Support\Collection;
use RonildoSousa\DevtoForLaravel\Contracts\ArticleEndpointInterface;
use RonildoSousa\DevtoForLaravel\Endpoints\BaseEndpoint;
use RonildoSousa\DevtoForLaravel\Entities\ArticleEntity;
use RonildoSousa\DevtoForLaravel\Enums\HttpMethod;
use RonildoSousa\DevtoForLaravel\Traits\{HasBuildUri, HasFilterByLatest, HasFilterByTags, HasFilterByUserArticles, HasFilterByUsername, HasItemsPerPage};
use Symfony\Component\HttpFoundation\Response;

class Articles extends BaseEndpoint implements ArticleEndpointInterface
{
    use HasItemsPerPage;
    use HasFilterByUserArticles;
    use HasFilterByTags;
    use HasFilterByUsername;
    use HasFilterByLatest;
    use HasBuildUri;

    private const URI_PATHS = [
        'latest', 'me', 'published', 'unpublished',
    ];

    public function publish(int $id): ArticleEntity|Collection
    {
        return $this->update($id, [
            'published' => true,
        ]);
    }

    public function unpublish(int $id): ArticleEntity|Collection
    {
        return $this->update($id, [
            'published' => false,
        ]);
    }

    public function create(array $payload): ArticleEntity|Collection
    {
        $response = $this->request(HttpMethod::POST, '/articles', ['article' => $payload]);

        if ($response->status() !== Response::HTTP_OK) {
            return $response->collect();
        }

        return new ArticleEntity($response->collect()->toArray());
    }

    public function update(int $id, array $payload): ArticleEntity|Collection
    {
        $response = $this->request(HttpMethod::PUT, "/articles/{$id}", ['article' => $payload]);

        if ($response->status() !== Response::HTTP_OK) {
            return $response->collect();
        }

        return new ArticleEntity($response->collect()->toArray());
    }

    public function find(int $id): ArticleEntity|Collection
    {
        $response = $this->request(HttpMethod::GET, "/articles/{$id}");

        if ($response->status() !== Response::HTTP_OK) {
            return $response->collect();
        }

        return new ArticleEntity($response->collect()->toArray());
    }

    public function get(): Collection
    {
        $uri = 'articles' . $this->buildUriWithQueryParams(self::URI_PATHS);

        $response = $this->request(HttpMethod::GET, $uri);

        if ($response->status() !== Response::HTTP_OK) {
            return $response->collect();
        }

        return $this->transform($response->collect(), ArticleEntity::class);
    }
}
