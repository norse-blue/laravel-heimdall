<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall\Permissions\Admin;

use NorseBlue\Heimdall\Permissions\DefinedPermission;

class ViewDashboardPermission extends DefinedPermission
{
    public static function definition(): array
    {
        return [
            'key' => 'admin-dashboard:view',
            'name' => __('View Admin Dashboard') ?? '',
            'description' => __('Allows the user to view the admin dashboard.') ?? '',
        ];
    }
}
