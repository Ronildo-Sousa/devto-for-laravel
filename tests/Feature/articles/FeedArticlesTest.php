<?php

declare(strict_types = 1);

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use RonildoSousa\DevtoForLaravel\Entities\Article;
use RonildoSousa\DevtoForLaravel\Facades\DevtoForLaravel;

beforeEach(function () {
    Http::preventStrayRequests();

    articleFakeRequest();
});

it('should get a feed article list', function () {

    $articles = DevtoForLaravel::articles()
        ->get();
    $first = $articles->first();

    expect($articles)
        ->toBeInstanceOf(Collection::class)
        ->and($first)
        ->toBeInstanceOf(Article::class)
        ->and($first->id)
        ->toBe(1544)
        ->and($first->title)
        ->toBe('The Line of Beauty172')
        ->and($first->slug)
        ->toBe('the-line-of-beauty172-39d8');
});
