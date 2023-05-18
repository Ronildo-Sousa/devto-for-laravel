<?php

declare(strict_types = 1);

namespace RonildoSousa\DevtoForLaravel\Traits;

trait HasItemsPerPage
{
    private ?int $per_page = null;

    private ?int $page = null;

    public function perPage(int $per_page): static
    {
        $this->per_page = $per_page;

        return $this;
    }

    public function fromPage(int $page): static
    {
        $this->page = $page;

        return $this;
    }
}
