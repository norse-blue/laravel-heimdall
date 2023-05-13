<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall\Registrar;

use NorseBlue\Heimdall\Permission;
use NorseBlue\Heimdall\Permissions\DefinedPermission;

/**
 * @extends BaseRegistrar<Permission>
 */
class PermissionRegistrar extends BaseRegistrar
{
    public function create(string $key, string $name, string $description = ''): Permission
    {
        return tap(
            new Permission($key, $name, $description),
            fn (Permission $permission) => $this->attach($permission)
        );
    }

    /**
     * @param  array<string>  $items
     * @return array<string>
     */
    public function filterValid(array $items): array
    {
        if (in_array('*', $items, true)) {
            $items = array_keys($this->items);
        }

        return collect(array_intersect($this->computeKeys($items), array_keys($this->items)))
            ->unique()
            ->sort()
            ->all();
    }

    /**
     * @return class-string<DefinedPermission>
     */
    protected function getDefinitionType(): string
    {
        return DefinedPermission::class;
    }

    /**
     * @return class-string<Permission>
     */
    protected function getType(): string
    {
        return Permission::class;
    }
}
