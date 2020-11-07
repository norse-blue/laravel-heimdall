<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall\Permissions\Admin\Users;

use NorseBlue\Heimdall\Permissions\DefinedPermission;

class UsersCreatePermission extends DefinedPermission
{
    public static function key(): string
    {
        return 'admin-users:create';
    }

    public static function definition(): array
    {
        return [
            'key' => static::key(),
            'name' => __('Admin Users - Create') ?? '',
            'description' => __('Allows the creation of users.') ?? '',
        ];
    }
}
