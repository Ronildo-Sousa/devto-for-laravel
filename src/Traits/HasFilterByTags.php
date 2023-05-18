<?php

declare(strict_types = 1);

namespace RonildoSousa\DevtoForLaravel\Traits;

trait HasFilterByTags
{
    private string $tags = '';

    private string $tags_exclude = '';

    public function withTags(array $tags): static
    {
        $this->tags = implode(',', $tags);

        return $this;
    }

    public function withoutTags(array $tags): static
    {
        $this->tags_exclude = implode(',', $tags);

        return $this;
    }
}
