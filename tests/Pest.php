<?php

declare(strict_types = 1);

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use RonildoSousa\DevtoForLaravel\Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;

uses(TestCase::class)->in(__DIR__);

function articleFakeRequest($without_api_key = false)
{
    $multipleArticles = config('articles_sample');
    $singleArticle    = config('single_article_sample');

    Http::fake([
        '/articles/me/unpublished' => function ($request) use ($multipleArticles, $without_api_key) {
            if (isWithoutCredentials($request, $without_api_key)) {
                return Http::response(['error' => 'unauthorized', 'status' => 401], Response::HTTP_UNAUTHORIZED);
            }

            return Http::response([$multipleArticles[2]]);
        },

        '/articles/me/published' => function ($request) use ($multipleArticles, $without_api_key) {
            if (isWithoutCredentials($request, $without_api_key)) {
                return Http::response(['error' => 'unauthorized', 'status' => 401], Response::HTTP_UNAUTHORIZED);
            }

            return Http::response([$multipleArticles[0], $multipleArticles[1]]);
        },

        '/articles/me/all' => function ($request) use ($multipleArticles, $without_api_key) {
            if (isWithoutCredentials($request, $without_api_key)) {
                return Http::response(['error' => 'unauthorized', 'status' => 401], Response::HTTP_UNAUTHORIZED);
            }

            return Http::response($multipleArticles);
        },

        '/articles/258' => function ($request) use ($singleArticle, $without_api_key) {
            if (isWithoutCredentials($request, $without_api_key)) {
                return Http::response(['error' => 'unauthorized', 'status' => 401], Response::HTTP_UNAUTHORIZED);
            }

            if (($request->method() == 'PUT')) {
                $requestData = json_decode($request->body(), true);
                $published   = data_get($requestData, 'article.published');

                $singleArticle[1]['published_timestamp'] = ($published) ? now()->format('Y-m-d H:i:s') : '';

                return $singleArticle[1];
            }

            return Http::response($singleArticle[0]);
        },

        '/articles/0' => Http::response(['error' => 'not found', 'status' => 404], Response::HTTP_NOT_FOUND),

        '/articles' => function ($request) use (
            $singleArticle,
            $multipleArticles,
            $without_api_key
        ) {
            if (isWithoutCredentials($request, $without_api_key)) {
                return Http::response(['error' => 'unauthorized', 'status' => 401], Response::HTTP_UNAUTHORIZED);
            }

            if ($request->method() == 'POST') {
                return Http::response($singleArticle[2]);
            }

            return Http::response($multipleArticles);
        },

        '/articles/latest' => Http::response($multipleArticles),

        '/articles?per_page=2' => Http::response([$multipleArticles[0], $multipleArticles[1]]),

        '*?tags=discuss' => Http::response([$multipleArticles[0], $multipleArticles[2]]),

        '*?tags_exclude=discuss' => Http::response([$multipleArticles[1]]),

        '*?username=ben' => Http::response([$multipleArticles[1], $multipleArticles[2]]),

        '*?page=2' => Http::response($multipleArticles),
    ]);
}

function isWithoutCredentials(Request $request, bool $without_api_key)
{
    return empty($request->headers()['api-key'][0]) || $without_api_key;
}
