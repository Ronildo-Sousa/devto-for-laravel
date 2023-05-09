<?php

declare(strict_types = 1);

use Illuminate\Support\Facades\Http;
use RonildoSousa\DevtoForLaravel\Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;

uses(TestCase::class)->in(__DIR__);

function articleFakeRequest()
{
    $multipleArticles = config('articles_sample');
    $singleArticle    = config('single_article_sample');

    Http::fake([
        '/articles/258'                => Http::response($singleArticle),
        '/articles/0'                  => Http::response(['error' => 'not found', 'status' => 404], Response::HTTP_NOT_FOUND),
        '/articles?per_page=30'        => Http::response($multipleArticles),
        '/articles/latest?per_page=30' => Http::response($multipleArticles),
        '/articles?per_page=2'         => Http::response([$multipleArticles[0], $multipleArticles[1]]),
        '*&tags=discuss'               => Http::response([$multipleArticles[0], $multipleArticles[2]]),
        '&tags_exclude=discuss'        => Http::response([$multipleArticles[1]]),
        '&username=ben'                => Http::response([$multipleArticles[1], $multipleArticles[2]]),
        '&page=2'                      => Http::response($multipleArticles),
    ]);
}
