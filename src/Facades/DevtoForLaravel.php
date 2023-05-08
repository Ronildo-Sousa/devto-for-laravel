<?php declare(strict_types = 1);

namespace RonildoSousa\DevtoForLaravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \RonildoSousa\DevtoForLaravel\DevtoForLaravel
 */
class DevtoForLaravel extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \RonildoSousa\DevtoForLaravel\DevtoForLaravel::class;
    }
}
