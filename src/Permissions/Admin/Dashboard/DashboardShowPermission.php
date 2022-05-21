<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall\Permissions\Admin\Dashboard;

use NorseBlue\Heimdall\Permissions\DefinedPermission;

class DashboardShowPermission extends DefinedPermission
{
    public static function definition(): array
    {
        // @phpstan-ignore-next-line
        return [
            'key' => static::key(),
            'name' => __('Admin Dashboard - Show') ?? '',
            'description' => __('Allows the display of the admin dashboard.') ?? '',
        ];
    }

    public static function key(): string
    {
        return 'admin-dashboard:show';
    }
}
