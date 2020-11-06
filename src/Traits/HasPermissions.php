<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall\Traits;

use JsonException;
use NorseBlue\Heimdall\AppPermissions;

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

        return AppPermissions::valid(json_decode($this->attributes[$this->getPermissionsColumn()], true, 512, JSON_THROW_ON_ERROR));
    }

    /**
     * @param array<string> $permissions
     *
     * @throws JsonException
     */
    public function setPermissionsAttribute(array $permissions): void
    {
        $this->attributes[$this->getPermissionsColumn()] = json_encode(AppPermissions::valid($permissions), JSON_THROW_ON_ERROR);
    }

    public function hasPermission(string $key): bool
    {
        return AppPermissions::has($key) && in_array($key, $this->permissions, true);
    }

    protected function getPermissionsColumn(): string
    {
        return $this->permission_column ?? config('heimdall.column_names.permissions') ?? 'permissions';
    }
}
