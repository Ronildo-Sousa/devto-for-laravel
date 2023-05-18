<?php

declare(strict_types = 1);

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use RonildoSousa\DevtoForLaravel\DTO\ArticleDTO;
use RonildoSousa\DevtoForLaravel\Entities\ArticleEntity;
use RonildoSousa\DevtoForLaravel\Facades\DevtoForLaravel;

beforeEach(function () {
    Http::preventStrayRequests();
});

it('should be able to update an user article', function () {
    articleFakeRequest();

    $article = ArticleDTO::fromArray([
        'title'         => 'my updated title',
        'description'   => 'my updated description',
        'body_markdown' => 'my updated body markdown',
        'tags'          => 'discuss',
    ]);

    $response = DevtoForLaravel::articles()
        ->update(258, $article);

    expect($response)
        ->toBeInstanceOf(ArticleEntity::class)
        ->and($response->title)
        ->toBe('my updated title')
        ->and($response->description)
        ->toBe('my updated description')
        ->and($response->body_markdown)
        ->toBe('my updated body markdown');
});

it('should be able to unpublish an user article', function () {
    articleFakeRequest();

    $response = DevtoForLaravel::articles()
        ->unpublish(258);

    expect($response)
        ->toBeInstanceOf(ArticleEntity::class)
        ->and($response->published_timestamp)
        ->toBe('');
});

it('should be able to publish an user article draft', function () {
    articleFakeRequest();
    Carbon::setTestNow('2023-05-12 20:28:42');

    $response = DevtoForLaravel::articles()
        ->publish(258);

    expect($response)
        ->toBeInstanceOf(ArticleEntity::class)
        ->and($response->published_timestamp)
        ->toBe((string)now());
});

it('should not be able to update without api-key', function () {
    articleFakeRequest(true);

    $article = ArticleDTO::fromArray([
        'title'         => 'my updated title',
        'description'   => 'my updated description',
        'body_markdown' => 'my updated body markdown',
        'tags'          => 'discuss',
    ]);
    $response = DevtoForLaravel::articles()
        ->update(258, $article);

    expect($response->get('status'))
        ->toBe(401)
        ->and($response->get('error'))
        ->toBe('unauthorized');
});
