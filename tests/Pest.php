<?php

declare(strict_types = 1);

use RonildoSousa\DevtoForLaravel\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);

function configFile(string $key = null): string|array
{
    if (is_null($key)) {
        return config('devto-for-laravel');
    }

    $keys        = explode('.', $key);
    $fileContent = include(getcwd() . '/config/' . $keys[0] . '.php');

    array_shift($keys);

    $tempContent = $fileContent;

    if (count($keys) > 0) {
        foreach ($keys as $item) {
            $tempContent = $tempContent[$item];
        }

        return $tempContent;
    }

    return $fileContent;
}
