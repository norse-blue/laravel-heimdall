<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall\Traits;

use JsonException;
use NorseBlue\Heimdall\AppPermissions;

/**
 * @property-read array<string> $all_permissions
 */
trait HasPermissionsAndRoles
{
    use HasRoles, HasPermissions {
        HasPermissions::getPermissionsAttribute insteadof HasRoles;
        HasRoles::getPermissionsAttribute as getRolesPermissionsAttribute;
    }

    /**
     * @return array<string>
     *
     * @throws JsonException
     */
    public function getAllPermissionsAttribute(): array
    {
        return collect($this->getPermissionsAttribute())
            ->merge($this->getRolesPermissionsAttribute())
            ->unique()
            ->sort()
            ->all();
    }

    public function hasPermission(string $key): bool
    {
        return AppPermissions::has($key) && in_array($key, $this->all_permissions, true);
    }
}
