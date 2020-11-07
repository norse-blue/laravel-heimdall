<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall\Permissions\Admin\Users;

use NorseBlue\Heimdall\Permissions\DefinedPermission;

class UsersEditPermission extends DefinedPermission
{
    public static function key(): string
    {
        return 'admin-users:edit';
    }

    public static function definition(): array
    {
        return [
            'key' => static::key(),
            'name' => __('Admin Users - Edit') ?? '',
            'description' => __('Allows the edition of users.') ?? '',
        ];
    }
}
