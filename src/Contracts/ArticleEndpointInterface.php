<?php declare(strict_types = 1);

namespace RonildoSousa\DevtoForLaravel\Contracts;

use Illuminate\Support\Collection;
use RonildoSousa\DevtoForLaravel\Entities\Article;

interface ArticleEndpointInterface
{
    public function find(int $id): Article|Collection;

    public function get(): Collection;

    public function update(int $id, array $payload): Article|Collection;

    public function create(array $payload): Article|Collection;
}
