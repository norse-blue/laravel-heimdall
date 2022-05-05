<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall\Permissions\Admin\Users;

use JetBrains\PhpStorm\ArrayShape;
use NorseBlue\Heimdall\Permissions\DefinedPermission;

class UsersListPermission extends DefinedPermission
{
    public static function key(): string
    {
        return 'admin-users:list';
    }

    /**
     * @return array{
     *     'key': string,
     *     'name': string,
     *     'description': string,
     * }
     */
    #[ArrayShape([
        'key' => 'string',
        'name' => 'string',
        'description' => 'string',
    ])]
    public static function definition(): array
    {
        // @phpstan-ignore-next-line
        return [
            'key' => static::key(),
            'name' => __('Admin Users - List') ?? '',
            'description' => __('Allows the listing of users.') ?? '',
        ];
    }
}
