<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall\Traits;

use JsonException;
use NorseBlue\Heimdall\Facades\Registrar;

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
        $permissions = collect($this->getPermissionsAttribute())
            ->merge($this->getRolesPermissionsAttribute())
            ->unique()
            ->sort()
            ->all();

        if (in_array('*', $permissions, true)) {
            return ['*'];
        }

        return $permissions;
    }

    public function hasPermission(string $key): bool
    {
        return Registrar::permissions()->has($key) && (
                $this->all_permissions === ['*'] || in_array(
                    Registrar::permissions()->computeKey($key),
                    $this->all_permissions,
                    true
                )
            );
    }
}
