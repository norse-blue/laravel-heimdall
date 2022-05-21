<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall\Traits;

use JsonException;
use NorseBlue\Heimdall\Facades\Registrar;

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

    /**
     * @return array<string>
     */
    public function getPermissionsAttribute(): array
    {
        $permissions = collect($this->roles)
            ->map(function ($role) {
                return Registrar::roles()->find($role)->permissions;
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

        return Registrar::roles()->filterValid(
            json_decode($this->attributes[$this->getRolesColumn()], true, 512, JSON_THROW_ON_ERROR)
        );
    }

    public function getRolesColumn(): string
    {
        return $this->roles_column ?? config('heimdall.column_names.roles') ?? 'roles';
    }

    public function hasPermission(string $key): bool
    {
        return Registrar::permissions()->has($key)
            && ($this->permissions === ['*']
                || in_array($key, $this->permissions, true)
            );
    }

    public function hasRole(string $key): bool
    {
        return Registrar::roles()->has($key) && in_array(Registrar::roles()->computeKey($key), $this->roles, true);
    }

    /**
     * @param array<string> $roles
     *
     * @throws JsonException
     */
    public function setRolesAttribute(array $roles): void
    {
        $this->attributes[$this->getRolesColumn()] = json_encode(
            Registrar::roles()->filterValid($roles),
            JSON_THROW_ON_ERROR
        );
    }
}
