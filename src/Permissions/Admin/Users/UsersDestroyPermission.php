<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall\Permissions\Admin\Users;

use JetBrains\PhpStorm\ArrayShape;
use NorseBlue\Heimdall\Permissions\DefinedPermission;

class UsersDestroyPermission extends DefinedPermission
{
    public static function key(): string
    {
        return 'admin-users:destroy';
    }

    #[ArrayShape([
        'key' => 'string',
        'name' => 'string',
        'description' => 'string',
    ])]
    public static function definition(): array
    {
        return [
            'key' => static::key(),
            'name' => __('Admin Users - Destroy') ?? '',
            'description' => __('Allows the destruction of users.') ?? '',
        ];
    }
}
