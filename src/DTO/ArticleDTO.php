<?php

declare(strict_types = 1);

namespace RonildoSousa\DevtoForLaravel\DTO;

class ArticleDTO
{
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly string $body_markdown,
        public readonly ?string $tags = null,
        public readonly bool $published = false,
        public readonly ?string $series = null,
        public readonly ?string $main_image = null,
        public readonly ?string $canonical_url = null,
        public readonly ?int $organization_id = null,
    ) {
    }

    public function toArray(): array
    {
        return (array) $this;
    }

    public static function fromArray(array $data): self
    {
        return new self(
            data_get($data, 'title'),
            data_get($data, 'description'),
            data_get($data, 'body_markdown'),
            data_get($data, 'tags'),
            data_get($data, 'published', false),
            data_get($data, 'series'),
            data_get($data, 'main_image'),
            data_get($data, 'canonical_url'),
            data_get($data, 'organization_id'),
        );
    }
}
