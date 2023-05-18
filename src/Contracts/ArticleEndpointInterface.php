<?php

declare(strict_types = 1);

namespace RonildoSousa\DevtoForLaravel\Contracts;

use Illuminate\Support\Collection;
use RonildoSousa\DevtoForLaravel\DTO\ArticleDTO;
use RonildoSousa\DevtoForLaravel\Entities\ArticleEntity;

interface ArticleEndpointInterface
{
    public function find(int $id): ArticleEntity|Collection;

    public function get(): Collection;

    public function update(int $id, ArticleDTO $payload): ArticleEntity|Collection;

    public function create(ArticleDTO $payload): ArticleEntity|Collection;
}
