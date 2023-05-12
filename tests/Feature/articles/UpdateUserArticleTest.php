<?php

declare(strict_types = 1);

use Illuminate\Support\Facades\Http;
use RonildoSousa\DevtoForLaravel\Entities\Article;
use RonildoSousa\DevtoForLaravel\Facades\DevtoForLaravel;

beforeEach(function () {
    Http::preventStrayRequests();
});

it('should be able to update an user article', function () {
    articleFakeRequest();

    $response = DevtoForLaravel::articles()
        ->update(258, [
            'title'         => 'my updated title',
            'description'   => 'my updated description',
            'body_markdown' => 'my updated body markdown',
        ]);

    expect($response)
        ->toBeInstanceOf(Article::class)
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
        ->toBeInstanceOf(Article::class)
        ->and($response->published_at)
        ->toBeNull()
        ->and($response->readable_publish_date)
        ->toBeNull()
        ->and($response->published_timestamp)
        ->toBe('');
});

it('should not be able to update without api-key', function () {
    articleFakeRequest(true);

    $response = DevtoForLaravel::articles()
        ->update(258, [
            'title'         => 'my updated title',
            'description'   => 'my updated description',
            'body_markdown' => 'my updated body markdown',
        ]);

    expect($response->get('status'))
        ->toBe(401)
        ->and($response->get('error'))
        ->toBe('unauthorized');
});
