<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall;

abstract class AppPermissions
{
    /**
     * @var array<string, Permission>
     */
    private static array $permissions = [];

    public static function clear(): void
    {
        static::$permissions = [];
    }

    public static function count(): int
    {
        return count(static::$permissions);
    }

    public static function empty(): bool
    {
        return static::count() === 0;
    }

    public static function find(string $key): ?Permission
    {
        return static::$permissions[$key] ?? null;
    }

    public static function has(string $key): bool
    {
        return static::find($key) !== null;
    }

    public static function attach(Permission $permission): void
    {
        static::$permissions[$permission->key] = $permission;
    }

    public static function create(string $key, string $name, string $description = ''): Permission
    {
        return tap(new Permission($key, $name, $description), static function (Permission $permission): void {
            static::attach($permission);
        });
    }

    /**
     * @param array<string> $permissions
     *
     * @return array<string>
     */
    public static function valid(array $permissions): array
    {
        if (in_array('*', $permissions, true)) {
            $permissions = array_keys(static::$permissions);
        }

        return collect(array_intersect($permissions, array_keys(static::$permissions)))
            ->unique()
            ->sort()
            ->all();
    }

    /**
     * @return array<string>
     */
    public static function all(): array
    {
        return static::valid(['*']);
    }
}
