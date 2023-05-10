<?php

declare(strict_types = 1);

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use RonildoSousa\DevtoForLaravel\Entities\Article;
use RonildoSousa\DevtoForLaravel\Facades\DevtoForLaravel;

beforeEach(function () {
    Http::preventStrayRequests();
});

it('should get articles from authenticated user', function () {
    articleFakeRequest();

    $articles = DevtoForLaravel::articles()
        ->me()
        ->get();
    $first = $articles->first();

    expect($articles)
        ->toBeInstanceOf(Collection::class)
        ->and($articles)
        ->each
        ->toBeInstanceOf(Article::class)
        ->and($first->id)
        ->toBe(1544)
        ->and($first->title)
        ->toBe('The Line of Beauty172')
        ->and($first->slug)
        ->toBe('the-line-of-beauty172-39d8');
});

it('should get an error without an api-key', function () {
    articleFakeRequest(true);

    $response = DevtoForLaravel::articles()
        ->me()
        ->get();

    expect($response->get('status'))
        ->toBe(401)
        ->and($response->get('error'))
        ->toBe('unauthorized');
});
