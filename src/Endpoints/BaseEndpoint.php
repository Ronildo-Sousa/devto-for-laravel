<?php

declare(strict_types=1);

namespace RonildoSousa\DevtoForLaravel\Endpoints;

use Illuminate\Support\Collection;
use RonildoSousa\DevtoForLaravel\DevtoForLaravel;

class BaseEndpoint
{
    protected DevtoForLaravel $service;

    public function __construct()
    {
        $this->service = new DevtoForLaravel();
    }

    protected function transform(Collection $data, string $entity): Collection
    {
        return $data->map(fn ($item) => new $entity($item));
    }
}
