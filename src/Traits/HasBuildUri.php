<?php

declare(strict_types = 1);

namespace RonildoSousa\DevtoForLaravel\Traits;

trait HasBuildUri
{
    protected function buildUriWithQueryParams(array $uriPaths = []): string
    {
        $classProperties = get_object_vars($this);
        $uriParams       = collect($classProperties)
            ->filter(fn ($value, $key) => !blank($value) && !in_array($key, $uriPaths));

        $path = collect($classProperties)
            ->filter(fn ($value, $key) => in_array($key, $uriPaths) && !blank($this->$key))
            ->map(fn ($value, $key) => ($this->shouldGetAllArticles($key) ? "{$this->me}/all" : $value))
            ->implode('/');

        $query = http_build_query($uriParams->toArray());

        return (!blank($path) ? "/{$path}" : '') . (!blank($query) ? "?{$query}" : '');
    }

    private function shouldGetAllArticles(string $key): bool
    {
        if ($key !== 'me' || !isset($this->me)) {
            return false;
        }

        return (!blank($this->me)) && ((isset($this->published) && !$this->published) && (isset($this->unpublished) && !$this->unpublished));
    }
}
