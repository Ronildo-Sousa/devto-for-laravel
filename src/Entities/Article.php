<?php

declare(strict_types = 1);

namespace RonildoSousa\DevtoForLaravel\Entities;

class Article
{
    public int $id;

    public string $title;

    public string $description;

    public string $slug;

    public function __construct(array $data)
    {
        $this->id          = data_get($data, 'id');
        $this->title       = data_get($data, 'title');
        $this->description = data_get($data, 'description');
        $this->slug        = data_get($data, 'slug');
    }
}