<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall\Roles;

class AdminRole extends DefinedRole
{
    /**
     * @return array{
     *     'key': string,
     *     'name': string,
     *     'description': string,
     *     'permissions': array<string>,
     * }
     */
    public static function definition(): array
    {
        return [
            'key' => static::key(),
            'name' => __('Administrator'),
            'description' => __('Application administrator'),
            'permissions' => ['*'],
        ];
    }

    public static function key(): string
    {
        return 'admin';
    }
}
