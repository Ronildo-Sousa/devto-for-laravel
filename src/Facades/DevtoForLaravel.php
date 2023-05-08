<?php

declare(strict_types = 1);

namespace RonildoSousa\DevtoForLaravel\Facades;

use Illuminate\Support\Facades\Facade;
use RonildoSousa\DevtoForLaravel\Endpoints\Articles\Articles;

/**
 * @see \RonildoSousa\DevtoForLaravel\DevtoForLaravel
 * @method static Articles articles()
 */
class DevtoForLaravel extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \RonildoSousa\DevtoForLaravel\DevtoForLaravel::class;
    }
}
