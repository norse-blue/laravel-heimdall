<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall\Contracts;

use JetBrains\PhpStorm\ArrayShape;

interface DefinesPermission extends DefinesEntity
{
    #[ArrayShape([
        'key' => 'string',
        'name' => 'string',
        'description' => 'string',
    ])]
    public static function definition(): array;
}
