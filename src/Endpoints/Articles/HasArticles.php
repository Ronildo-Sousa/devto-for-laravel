<?php declare(strict_types = 1);

namespace RonildoSousa\DevtoForLaravel\Endpoints\Articles;

trait HasArticles
{
    public function articles(): Articles
    {
        return new Articles();
    }
}
