<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall;

use NorseBlue\Heimdall\Enums\EntityType;
use NorseBlue\Heimdall\Registrar\PermissionRegistrar;
use NorseBlue\Heimdall\Registrar\RoleRegistrar;

readonly class Registrar
{
    protected PermissionRegistrar $permissions;

    protected RoleRegistrar $roles;

    public function __construct(?PermissionRegistrar $permissionRegistrar = null, ?RoleRegistrar $roleRegistrar = null)
    {
        $this->permissions = $permissionRegistrar ?: new PermissionRegistrar();
        $this->roles = $roleRegistrar ?: new RoleRegistrar();
    }

    /**
     * @param array{
     *  key: string,
     *  name: string,
     *  description: string,
     *  permissions?: array<string>,
     * } $params
     */
    public function create(EntityType $type, array $params): Entity
    {
        $registrar = match ($type) {
            EntityType::Permission => $this->permissions,
            EntityType::Role => $this->roles,
        };

        return $registrar->create(...$params);
    }

    public function permissions(): PermissionRegistrar
    {
        return $this->permissions;
    }

    public function roles(): RoleRegistrar
    {
        return $this->roles;
    }
}
