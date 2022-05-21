<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall;

use NorseBlue\Heimdall\Concerns\Entity;
use NorseBlue\Heimdall\Exceptions\InvalidRoleKeyException;

class Role extends Entity
{
    /**
     * @var array<string>
     */
    public readonly array $permissions;

    /**
     * @param array<string>|string $permissions
     */
    public function __construct(
        public readonly string $key,
        public readonly string $name,
        public readonly string $description = '',
        array|string $permissions = []
    ) {
        if ($key === '*') {
            throw new InvalidRoleKeyException('Wildcard key is not allowed for roles.');
        }

        $this->permissions = is_string($permissions) ? [$permissions]
            : collect($permissions)
                ->unique()
                ->sort()
                ->all();
    }

    /**
     * @return array{
     *  key: string,
     *  name: string,
     *  description: string,
     *  permissions: array<string>,
     * }
     */
    public function jsonSerialize(): array
    {
        return array_merge(
            parent::jsonSerialize(),
            ['permissions' => $this->permissions],
        );
    }
}
