<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall;

use Illuminate\Support\Collection;

abstract class AppRoles
{
    /**
     * @var array<string, Role>
     */
    private static array $roles = [];

    public static function clear(): void
    {
        static::$roles = [];
    }

    public static function count(): int
    {
        return count(static::$roles);
    }

    public static function empty(): bool
    {
        return static::count() === 0;
    }

    public static function find(string $key): ?Role
    {
        return static::$roles[$key] ?? null;
    }

    public static function has(string $key): bool
    {
        return static::find($key) !== null;
    }

    public static function attach(Role $role): void
    {
        static::$roles[$role->key] = $role;
    }

    /**
     * @param array<string> $permissions
     *
     * @return \NorseBlue\Heimdall\Role
     */
    public static function create(string $key, string $name, array $permissions, string $description = ''): Role
    {
        return tap(new Role($key, $name, $permissions, $description), static fn (Role $role) => static::$roles[$key] = $role);
    }

    /**
     * @param array<string> $roles
     *
     * @return array<string>
     */
    public static function valid(array $roles, bool $with_permissions = false): array
    {
        if (in_array('*', $roles, true)) {
            $roles = array_keys(static::$roles);
        }

        return collect(array_intersect($roles, array_keys(static::$roles)))
            ->unique()
            ->sort()
            ->when($with_permissions, function (Collection $roles): Collection {
                return $roles->map(fn (string $role) => [$role => static::find($role)->permissions])
                    ->collapse();
            })
            ->all();
    }

    /**
     * @return array<string>
     */
    public static function all(bool $with_permissions = false): array
    {
        return static::valid(['*'], $with_permissions);
    }
}
