<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall\Contracts;

use JetBrains\PhpStorm\ArrayShape;

interface DefinesRole extends DefinesEntity
{
    #[ArrayShape([
        'key' => "string",
        'name' => "string",
        'permissions' => "string[]",
        'description' => "string"
    ])]
    public static function definition(): array;
}
