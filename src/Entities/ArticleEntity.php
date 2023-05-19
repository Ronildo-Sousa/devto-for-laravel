<?php

declare(strict_types = 1);

namespace RonildoSousa\DevtoForLaravel\Entities;

class ArticleEntity
{
    public int $id;

    public string $title;

    public string $description;

    public ?bool $published;

    public string $slug;

    public string $path;

    public string $url;

    public int $comments_count;

    public int $public_reactions_count;

    public ?int $collection_id;

    public ?string $published_timestamp;

    public int $positive_reactions_count;

    public ?string $cover_image;

    public ?string $social_image;

    public ?string $canonical_url;

    public ?string $created_at;

    public ?string $edited_at;

    public ?string $crossposted_at;

    public ?string $published_at;

    public ?string $last_comment_at;

    public ?int $reading_time_minutes;

    public ?string $tag_list;

    public ?string $tags;

    public ?int $page_views_count;

    public ?string $readable_publish_date;

    public ?string $body_markdown;

    public ?string $body_html;

    public array $user;

    public ?array $flare_tag;

    public function __construct(array $data)
    {
        $this->id = data_get($data, 'id');

        $this->title = data_get($data, 'title');

        $this->description = data_get($data, 'description');

        $this->published = data_get($data, 'published', false);

        $this->slug = data_get($data, 'slug');

        $this->path = data_get($data, 'path');

        $this->url = data_get($data, 'url');

        $this->comments_count = data_get($data, 'comments_count', 0);

        $this->public_reactions_count = data_get($data, 'public_reactions_count', 0);

        $this->page_views_count = data_get($data, 'page_views_count', 0);

        $this->readable_publish_date = data_get($data, 'readable_publish_date');

        $this->published_timestamp = data_get($data, 'published_timestamp');

        $this->positive_reactions_count = data_get($data, 'positive_reactions_count', 0);

        $this->cover_image = data_get($data, 'cover_image');

        $this->social_image = data_get($data, 'social_image');

        $this->canonical_url = data_get($data, 'canonical_url');

        $this->created_at = data_get($data, 'created_at');

        $this->edited_at = data_get($data, 'edited_at');

        $this->crossposted_at = data_get($data, 'edited_at');

        $this->published_at = data_get($data, 'published_at');

        $this->last_comment_at = data_get($data, 'last_comment_at');

        $this->reading_time_minutes = data_get($data, 'reading_time_minutes', 0);

        $tag_list       = data_get($data, 'tag_list');
        $this->tag_list = is_array($tag_list) ? implode(', ', $tag_list) : $tag_list;

        $tags       = data_get($data, 'tags');
        $this->tags = is_array($tags) ? implode(', ', $tags) : $tags;

        $this->body_html = data_get($data, 'body_html');

        $this->body_markdown = data_get($data, 'body_markdown');

        $this->user = data_get($data, 'user');

        $this->flare_tag = data_get($data, 'flare_tag');
    }

    public function toArray(): array
    {
        return (array) $this;
    }
}
