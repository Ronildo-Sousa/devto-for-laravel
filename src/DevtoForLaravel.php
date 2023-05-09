<?php

declare(strict_types = 1);

namespace RonildoSousa\DevtoForLaravel;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use RonildoSousa\DevtoForLaravel\Endpoints\Articles\HasArticles;

class DevtoForLaravel
{
    use HasArticles;

    public PendingRequest $api;

    public function __construct()
    {
        $this->api = Http::withHeaders([])->baseUrl(config('devto-for-laravel.devto.base_url'));
    }
}
