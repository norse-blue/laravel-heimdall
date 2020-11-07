<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall\Roles;

class AdminRole extends DefinedRole
{
    public static function key(): string
    {
        return 'admin';
    }

    public static function definition(): array
    {
        return [
            'key' => static::key(),
            'name' => 'Administrator',
            'permissions' => ['*'],
            'description' => 'Application administrator',
        ];
    }
}
