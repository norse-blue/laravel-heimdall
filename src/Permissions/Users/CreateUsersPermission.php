<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall\Permissions\Users;

use NorseBlue\Heimdall\Permissions\DefinedPermission;

class CreateUsersPermission extends DefinedPermission
{
    public static function definition(): array
    {
        return [
            'key' => 'users:create',
            'name' => __('Create users'),
            'description' => __('Allows the user to create users.'),
        ];
    }
}
