<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall\Contracts;

interface DefinesEntity
{
    /**
     * @return array{
     *   'key': string,
     *   'name': string,
     *   'description': string,
     *   'permissions?': array<string>,
     * }
     */
    public static function definition(): array;

    public static function key(): string;
}
