<?php

declare(strict_types = 1);

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use RonildoSousa\DevtoForLaravel\Entities\ArticleEntity;
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
        ->and($articles)
        ->each
        ->toBeInstanceOf(ArticleEntity::class)
        ->and($first->id)
        ->toBe(1544)
        ->and($first->title)
        ->toBe('The Line of Beauty172')
        ->and($first->slug)
        ->toBe('the-line-of-beauty172-39d8');
});

it('should be able to set items per page', function () {
    $articles = DevtoForLaravel::articles()
        ->perPage(2)
        ->get();

    expect($articles)
        ->toBeInstanceOf(Collection::class)
        ->and($articles->count())
        ->toBe(2)
        ->and($articles)
        ->each
        ->toBeInstanceOf(ArticleEntity::class);
});

it('should be able to get items with requested tags', function () {
    $articles = DevtoForLaravel::articles()
        ->withTags(['discuss'])
        ->get();

    expect($articles)
        ->toBeInstanceOf(Collection::class)
        ->and($articles)
        ->each(function ($article) {
            $article->toBeInstanceOf(ArticleEntity::class);
            $article->tags->toContain('discuss');
        });
});

it('should be able to get items without requested tags', function () {
    $articles = DevtoForLaravel::articles()
        ->withoutTags(['discuss'])
        ->get();

    expect($articles)
        ->toBeInstanceOf(Collection::class)
        ->and($articles)
        ->each(function ($article) {
            $article->toBeInstanceOf(ArticleEntity::class);
            $article->tags->not->toContain('discuss');
        });
});

it('should be able to get articles from a given user', function () {
    $articles = DevtoForLaravel::articles()
        ->from('ben')
        ->get();

    expect($articles)
        ->toBeInstanceOf(Collection::class)
        ->and($articles)
        ->each(function ($article) {
            $article->toBeInstanceOf(ArticleEntity::class);
            $article->user->toContain('ben');
        });
});

it('should be able to choose a page result', function () {
    $articles = DevtoForLaravel::articles()
        ->fromPage(2)
        ->get();

    expect($articles)
        ->toBeInstanceOf(Collection::class)
        ->and($articles)
        ->each
        ->toBeInstanceOf(ArticleEntity::class);
});

it('should be able to get latest articles', function () {
    $articles = DevtoForLaravel::articles()
        ->latest()
        ->get();

    expect($articles)
        ->toBeInstanceOf(Collection::class)
        ->and($articles)
        ->each
        ->toBeInstanceOf(ArticleEntity::class);
});

it('should be able to get an article by id', function () {
    $article = DevtoForLaravel::articles()
        ->find(258);

    expect($article)
        ->toBeInstanceOf(ArticleEntity::class)
        ->and($article->id)
        ->toBe(258)
        ->and($article->title)
        ->toBe('Pale Kings and Princes179')
        ->and($article->slug)
        ->toBe('pale-kings-and-princes179-381c');
});

it('should get an error passging an invalid id', function () {
    $response = DevtoForLaravel::articles()
        ->find(0);

    expect($response->get('status'))
        ->toBe(404)
        ->and($response->get('error'))
        ->toBe('not found');
});
