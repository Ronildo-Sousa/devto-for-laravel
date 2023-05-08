<?php

declare(strict_types = 1);

use Illuminate\Support\Facades\Http;
use RonildoSousa\DevtoForLaravel\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

function articleFakeRequest(bool $single = false)
{
    $data = config('articles_sample');

    if ($single) {
        $data = $data[0];
    }

    Http::fake([
        '/articles'            => Http::response($data),
        '/articles?per_page=2' => Http::response([$data[0], $data[1]]),
        '*&tags=*'             => Http::response([$data[0], $data[2]]),
    ]);
}
