<?php

declare(strict_types = 1);

namespace RonildoSousa\DevtoForLaravel\Traits;

trait HasFilterByUserArticles
{
    private string $me = '';

    private string $published = '';

    private string $unpublished = '';

    public function me(): static
    {
        $this->me = 'me';

        return $this;
    }

    public function published(): static
    {
        $this->published = 'published';

        return $this;
    }
    public function unpublished(): static
    {
        $this->unpublished = 'unpublished';

        return $this;
    }
}
