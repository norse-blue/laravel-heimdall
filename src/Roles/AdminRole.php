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

    /**
     * @return array{
     *     'key': string,
     *     'name': string,
     *     'permissions': array<string>,
     *     'description': string,
     * }
     */
    #[ArrayShape([
        'key' => 'string',
        'name' => 'string',
        'permissions' => 'string[]',
        'description' => 'string',
    ])]
    public static function definition(): array
    {
        // @phpstan-ignore-next-line
        return [
            'key' => static::key(),
            'name' => __('Administrator'),
            'permissions' => ['*'],
            'description' => __('Application administrator'),
        ];
    }
}
