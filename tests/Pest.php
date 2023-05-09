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
        '/articles?per_page=30' => Http::response($data),
        '/articles?per_page=2'  => Http::response([$data[0], $data[1]]),
        '*&tags=discuss'        => Http::response([$data[0], $data[2]]),
        '&tags_exclude=discuss' => Http::response([$data[1]]),
        '&username=ben'         => Http::response([$data[1], $data[2]]),
        '&page=2'               => Http::response($data),
    ]);
}
