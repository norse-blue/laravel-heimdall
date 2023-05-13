<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall\Registrar;

use Illuminate\Support\Collection;
use NorseBlue\Heimdall\Role;
use NorseBlue\Heimdall\Roles\DefinedRole;

/**
 * @extends BaseRegistrar<Role>
 */
class RoleRegistrar extends BaseRegistrar
{
    /**
     * @return array<string>
     */
    public function all(bool $with_permissions = false): array
    {
        return $this->filterValid(['*'], $with_permissions);
    }

    /**
     * @param  array<string>  $permissions
     */
    public function create(string $key, string $name, string $description = '', array $permissions = []): Role
    {
        return tap(
            new Role($key, $name, $description, $permissions),
            fn (Role $role) => $this->attach($role)
        );
    }

    /**
     * @param  array<string>  $items
     * @return array<string>
     */
    public function filterValid(array $items, bool $with_permissions = false): array
    {
        if (in_array('*', $items, true)) {
            $items = array_keys($this->items);
        }

        return collect(array_intersect($this->computeKeys($items), array_keys($this->items)))
            ->unique()
            ->sort()
            ->when($with_permissions, function (Collection $roles): Collection {
                return $roles->map(fn (string $role) => [$role => $this->find($role)?->permissions])
                    ->collapse();
            })
            ->all();
    }

    /**
     * @return class-string<DefinedRole>
     */
    protected function getDefinitionType(): string
    {
        return DefinedRole::class;
    }

    /**
     * @return class-string<Role>
     */
    protected function getType(): string
    {
        return Role::class;
    }
}
