<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall\Permissions\Admin\Dashboard;

use JetBrains\PhpStorm\ArrayShape;
use NorseBlue\Heimdall\Permissions\DefinedPermission;

class DashboardShowPermission extends DefinedPermission
{
    public static function key(): string
    {
        return 'admin-dashboard:show';
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
            'name' => __('Admin Dashboard - Show') ?? '',
            'description' => __('Allows the display of the admin dashboard.') ?? '',
        ];
    }
}
