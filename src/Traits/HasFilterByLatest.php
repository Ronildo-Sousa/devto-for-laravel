<?php

declare(strict_types = 1);

namespace RonildoSousa\DevtoForLaravel\Traits;

trait HasFilterByLatest
{
    private string $latest = '';

    public function latest(): static
    {
        $this->latest = 'latest';

        return $this;
    }
}
