<?php

declare(strict_types=1);

namespace RonildoSousa\DevtoForLaravel\Endpoints;

use Illuminate\Support\Collection;
use RonildoSousa\DevtoForLaravel\DevtoForLaravel;
use RonildoSousa\DevtoForLaravel\Entities\Article;

class BaseEndpoint
{
    protected DevtoForLaravel $service;

    public function __construct()
    {
        $this->service = new DevtoForLaravel();
    }

    protected function transform(mixed $data, string $entity): Collection
    {
        return collect($data)
            ->map(fn ($item) => new $entity($item));
    }
}
