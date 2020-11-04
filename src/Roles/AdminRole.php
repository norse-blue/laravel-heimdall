<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall\Roles;

class AdminRole extends DefinedRole
{
    public static function definition(): array
    {
        return [
            'key' => 'admin',
            'name' => 'Administrator',
            'permissions' => ['*'],
            'description' => 'Application administrator',
        ];
    }
}
