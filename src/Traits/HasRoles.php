<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall\Traits;

use JsonException;
use NorseBlue\Heimdall\AppPermissions;
use NorseBlue\Heimdall\AppRoles;

/**
 * @property array<string> $roles
 *
 * @property-read array<string> $permissions
 */
trait HasRoles
{
    public static function bootHasRoles(): void
    {
        static::saving(function ($model): void {
            $model->setRolesAttribute($model->roles);
        });
    }

    public function getRolesColumn(): string
    {
        return $this->roles_column ?? config('heimdall.column_names.roles') ?? 'roles';
    }

    /**
     * @return array<string>
     *
     * @throws JsonException
     */
    public function getRolesAttribute(): array
    {
        if (! isset($this->attributes[$this->getRolesColumn()])) {
            return [];
        }

        return AppRoles::valid(json_decode($this->attributes[$this->getRolesColumn()], true, 512, JSON_THROW_ON_ERROR));
    }

    /**
     * @param array<string> $roles
     *
     * @throws JsonException
     */
    public function setRolesAttribute(array $roles): void
    {
        $this->attributes[$this->getRolesColumn()] = json_encode(AppRoles::valid($roles), JSON_THROW_ON_ERROR);
    }

    /**
     * @return array<string>
     */
    public function getPermissionsAttribute(): array
    {
        $permissions = collect($this->roles)
            ->map(function ($role) {
                return AppRoles::find($role)->permissions;
            })
            ->flatten()
            ->unique()
            ->sort()
            ->values()
            ->all();

        if (in_array('*', $permissions, true)) {
            return ['*'];
        }

        return $permissions;
    }

    public function hasRole(string $key): bool
    {
        return AppRoles::has($key) && in_array(AppRoles::computeKey($key), $this->roles, true);
    }

    public function hasPermission(string $key): bool
    {
        return AppPermissions::has($key) && ($this->permissions === ['*'] || in_array($key, $this->permissions, true));
    }
}
