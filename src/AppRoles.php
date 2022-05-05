<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall;

use Illuminate\Support\Collection;
use InvalidArgumentException;
use JetBrains\PhpStorm\Pure;
use NorseBlue\Heimdall\Roles\DefinedRole;

abstract class AppRoles
{
    /**
     * @var array<string, Role>
     */
    private static array $roles = [];

    public static function clear(): void
    {
        self::$roles = [];
    }

    public static function count(): int
    {
        return count(self::$roles);
    }

    #[Pure]
    public static function isEmpty(): bool
    {
        return static::count() === 0;
    }

    public static function find(string $key): ?Role
    {
        return self::$roles[static::computeKey($key)] ?? null;
    }

    public static function has(string $key): bool
    {
        return static::find(static::computeKey($key)) !== null;
    }

    public static function attach(string|Role $role): Role
    {
        if (is_string($role)) {
            if (! is_subclass_of($role, DefinedRole::class)) {
                throw new InvalidArgumentException("The role ${role} is not of type " . DefinedRole::class . '.');
            }

            return static::create(...array_values($role::definition()));
        }

        if (! $role instanceof Role) {
            throw new InvalidArgumentException('The role is not of type ' . Role::class . '.');
        }

        return self::$roles[$role->key] = $role;
    }

    /**
     * @param array<string> $permissions
     */
    public static function create(string $key, string $name, array $permissions, string $description = ''): Role
    {
        return tap(new Role($key, $name, $permissions, $description), static function (Role $role) use ($key): void {
            self::$roles[$key] = $role;
        });
    }

    /**
     * @param array<string> $roles
     *
     * @return array<string>
     */
    public static function valid(array $roles, bool $with_permissions = false): array
    {
        if (in_array('*', $roles, true)) {
            $roles = array_keys(self::$roles);
        }

        return collect(array_intersect(static::computeKeys($roles), array_keys(self::$roles)))
            ->unique()
            ->sort()
            ->when($with_permissions, function (Collection $roles): Collection {
                return $roles->map(fn (string $role) => [$role => static::find($role)?->permissions])
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
        if (is_subclass_of($key, DefinedRole::class)) {
            return $key::key();
        }

        return $key;
    }
}
