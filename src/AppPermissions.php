<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall;

use InvalidArgumentException;
use JetBrains\PhpStorm\Pure;
use NorseBlue\Heimdall\Permissions\DefinedPermission;

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

    #[Pure]
    public static function isEmpty(): bool
    {
        return static::count() === 0;
    }

    public static function find(string $key): ?Permission
    {
        return static::$permissions[static::computeKey($key)] ?? null;
    }

    public static function has(string $key): bool
    {
        return static::find(static::computeKey($key)) !== null;
    }

    public static function attach(string|Permission $permission): Permission
    {
        if (is_string($permission)) {
            if (! is_subclass_of($permission, DefinedPermission::class)) {
                throw new InvalidArgumentException(
                    "The permission ${permission} is not of type " . DefinedPermission::class . '.'
                );
            }

            return static::create(...array_values($permission::definition()));
        }

        if (! $permission instanceof Permission) {
            throw new InvalidArgumentException('The permission is not of type ' . Permission::class . '.');
        }

        return static::$permissions[$permission->key] = $permission;
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

        return collect(array_intersect(static::computeKeys($permissions), array_keys(static::$permissions)))
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

    /**
     * @param array<string> $keys
     *
     * @return array<string>
     */
    public static function computeKeys(array $keys): array
    {
        $computed = [];
        foreach ($keys as $key) {
            $computed[] = static::computeKey($key);
        }

        return $computed;
    }

    public static function computeKey(string $key): string
    {
        if (is_subclass_of($key, DefinedPermission::class)) {
            return $key::key();
        }

        return $key;
    }
}
