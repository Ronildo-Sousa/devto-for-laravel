<?php

declare(strict_types = 1);

use Illuminate\Support\Facades\Http;
use RonildoSousa\DevtoForLaravel\DTO\ArticleDTO;
use RonildoSousa\DevtoForLaravel\Entities\ArticleEntity;
use RonildoSousa\DevtoForLaravel\Facades\DevtoForLaravel;

beforeEach(function () {
    Http::preventStrayRequests();
});

it('should be able to create an article', function () {
    articleFakeRequest();
    $article = ArticleDTO::fromArray([
        'title'         => 'My created article title',
        'description'   => 'My created article description',
        'body_markdown' => '# My created article body',
        'published'     => true,
        'main_image'    => 'https://picsum.photos/200/300',
        'tags'          => 'discuss',
    ]);

    $response = DevtoForLaravel::articles()
        ->create($article);

    expect($response)
        ->toBeInstanceOf(ArticleEntity::class)
        ->and($response->title)
        ->toBe('My created article title')
        ->and($response->description)
        ->toBe('My created article description')
        ->and($response->body_markdown)
        ->toBe('# My created article body');
});

it('should not be able to create an article without api-key', function () {
    articleFakeRequest(true);

    $article = ArticleDTO::fromArray([
        'title'         => 'My created article title',
        'description'   => 'My created article description',
        'body_markdown' => '# My created article body',
        'tags'          => 'discuss',
    ]);

    $response = DevtoForLaravel::articles()
        ->create($article);

    expect($response->get('error'))
        ->toBe('unauthorized')
        ->and($response->get('status'))
        ->toBe(401);
});
