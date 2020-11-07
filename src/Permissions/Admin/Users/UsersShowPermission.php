<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall\Permissions\Admin\Users;

use NorseBlue\Heimdall\Permissions\DefinedPermission;

class UsersShowPermission extends DefinedPermission
{
    public static function key(): string
    {
        return 'admin-users:show';
    }

    public static function definition(): array
    {
        return [
            'key' => static::key(),
            'name' => __('Admin Users - Show') ?? '',
            'description' => __('Allows the display of users.') ?? '',
        ];
    }
}
