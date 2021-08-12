<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall\Roles;

use JetBrains\PhpStorm\ArrayShape;

class AdminRole extends DefinedRole
{
    public static function key(): string
    {
        return 'admin';
    }

    #[ArrayShape([
        'key' => "string",
        'name' => "string",
        'permissions' => "string[]",
        'description' => "string",
    ])]
    public static function definition(): array
    {
        return [
            'key' => static::key(),
            'name' => __('Administrator'),
            'permissions' => ['*'],
            'description' => __('Application administrator'),
        ];
    }
}
