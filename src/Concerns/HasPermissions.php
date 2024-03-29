<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall\Concerns;

use JsonException;
use NorseBlue\Heimdall\Facades\Registrar;

/**
 * @property-read array<string> $permissions
 */
trait HasPermissions
{
    public static function bootHasPermissions(): void
    {
        static::saving(function ($model): void {
            $model->setPermissionsAttribute($model->permissions);
        });
    }

    /**
     * @return array<string>
     *
     * @throws JsonException
     */
    public function getPermissionsAttribute(): array
    {
        if (! isset($this->attributes[$this->getPermissionsColumn()])) {
            return [];
        }

        $permissions = json_decode($this->attributes[$this->getPermissionsColumn()], true, 512, JSON_THROW_ON_ERROR);
        if (in_array('*', $permissions, true)) {
            return ['*'];
        }

        return Registrar::permissions()->filterValid($permissions);
    }

    public function hasPermission(string $key): bool
    {
        return Registrar::permissions()->has($key)
            && ($this->permissions === ['*']
                || in_array(Registrar::permissions()->computeKey($key), $this->permissions, true)
            );
    }

    /**
     * @param  array<string>  $permissions
     *
     * @throws JsonException
     */
    public function setPermissionsAttribute(array $permissions): void
    {
        $this->attributes[$this->getPermissionsColumn()] = json_encode(
            in_array('*', $permissions, true) ? ['*'] : Registrar::permissions()->filterValid($permissions),
            JSON_THROW_ON_ERROR
        );
    }

    protected function getPermissionsColumn(): string
    {
        return $this->permission_column ?? config('heimdall.column_names.permissions') ?? 'permissions';
    }
}
