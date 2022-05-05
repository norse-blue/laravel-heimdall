<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall\Contracts;

use JetBrains\PhpStorm\ArrayShape;

interface DefinesRole extends DefinesEntity
{
    /**
     * @return array{
     *     'key': string,
     *     'name': string,
     *     'permissions': array<string>,
     *     'description': string,
     * }
     */
    #[ArrayShape([
        'key' => 'string',
        'name' => 'string',
        'permissions' => 'string[]',
        'description' => 'string',
    ])]
    public static function definition(): array;
}
