<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall;

use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;
use NorseBlue\HandyProperties\Traits\HasPropertyAccessors;

/**
 * @property-read string $key
 * @property-read string $name
 * @property-read string $description
 */
class Permission implements JsonSerializable
{
    use HasPropertyAccessors;

    /**
     * The key identifier for the permission.
     */
    private string $key;

    /**
     * The name of the permission.
     */
    private string $name;

    /**
     * The permission's description.
     */
    private string $description;

    public function __construct(string $key, string $name, string $description = '')
    {
        $this->key = $key;
        $this->name = $name;
        $this->description = $description;
    }

    /**
     * @return array<string, string>{
     *  key: string,
     *  name: string,
     *  description: string
     * }
     */
    #[ArrayShape([
        'key' => 'string',
        'name' => 'string',
        'description' => 'string',
    ])]
    public function jsonSerialize(): array
    {
        return [
            'key' => $this->key,
            'name' => $this->name,
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
}
