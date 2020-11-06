<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall;

use JsonSerializable;
use NorseBlue\HandyProperties\Traits\HasPropertyAccessors;
use NorseBlue\Heimdall\Exceptions\InvalidRoleKeyException;

/**
 * @property-read string $key
 * @property-read string $name
 * @property-read array<string> $permissions
 * @property-read string $description
 */
class Role implements JsonSerializable
{
    use HasPropertyAccessors;

    /**
     * The key identifier for the role.
     */
    private string $key;

    /**
     * The name of the role.
     */
    private string $name;

    /**
     * The role's description.
     */
    private string $description;

    /**
     * The role's permissions.
     *
     * @var array<string>
     */
    private array $permissions;

    /**
     * @param string|array<string> $permissions
     */
    public function __construct(string $key, string $name, $permissions, string $description = '')
    {
        if ($key === '*') {
            throw new InvalidRoleKeyException("Wildcard roles are not allowed.");
        }

        $this->key = $key;
        $this->name = $name;
        $this->description = $description;
        $this->permissions = is_string($permissions) ? [$permissions]
            : collect($permissions)
                ->unique()
                ->sort()
                ->all();
    }

    /**
     * @return array<string, mixed>{
     *  key: string,
     *  name: string,
     *  permissions: array,
     *  description: string,
     * }
     */
    public function jsonSerialize(): array
    {
        return [
            'key' => $this->key,
            'name' => $this->name,
            'permissions' => $this->permissions,
            'description' => $this->description,
        ];
    }

    protected function accessorKey(): string
    {
        return $this->key;
    }

    protected function accessorName(): string
    {
        return $this->name;
    }

    protected function accessorDescription(): string
    {
        return $this->description;
    }

    /**
     * @return array<string>
     */
    protected function accessorPermissions(): array
    {
        return $this->permissions;
    }
}
