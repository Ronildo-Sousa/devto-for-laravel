<?php

declare(strict_types = 1);

namespace RonildoSousa\DevtoForLaravel\Endpoints;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;
use RonildoSousa\DevtoForLaravel\DevtoForLaravel;
use RonildoSousa\DevtoForLaravel\Enums\HttpMethod;

class BaseEndpoint
{
    private DevtoForLaravel $service;

    public function __construct()
    {
        $this->service = new DevtoForLaravel();
    }

    public function request(HttpMethod $method, string $uri, array $payload = null): Response
    {
        return $this->service
            ->api
            ->{$method->value}($uri, $payload);
    }

    protected function transform(Collection $data, string $entity): Collection
    {
        return $data->map(fn ($item) => new $entity($item));
    }
}
