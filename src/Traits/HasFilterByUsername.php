<?php

declare(strict_types = 1);

namespace RonildoSousa\DevtoForLaravel\Traits;

trait HasFilterByUsername
{
    private string $username = '';

    public function from(string $name): static
    {
        $this->username = $name;

        return $this;
    }
}
