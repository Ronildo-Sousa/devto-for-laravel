<?php

declare(strict_types = 1);

namespace RonildoSousa\DevtoForLaravel\Entities;

class Article
{
    public readonly int $id;

    public readonly string $title;

    public readonly string $description;

    public readonly string $slug;

    public readonly string $published_timestamp;

    public readonly ?string $body_markdown;

    public readonly ?string $body_html;

    public readonly ?string $tags;

    public readonly array $user;

    public function __construct(array $data)
    {
        $this->id = data_get($data, 'id');

        $this->title = data_get($data, 'title');

        $this->description = data_get($data, 'description');

        $this->slug = data_get($data, 'slug');

        $this->published_timestamp = data_get($data, 'published_timestamp');

        $this->body_html = data_get($data, 'body_html');

        $this->body_markdown = data_get($data, 'body_markdown');

        $tags       = data_get($data, 'tags');
        $this->tags = is_array($tags) ? implode(', ', $tags) : $tags;

        $this->user = data_get($data, 'user');
    }
}
