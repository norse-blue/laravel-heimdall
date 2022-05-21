<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall\Concerns;

use JsonSerializable;

abstract class Entity implements JsonSerializable
{
    public function __construct(
        public readonly string $key,
        public readonly string $name,
        public readonly string $description = ''
    ) {
    }

    /**
     * @return array{
     *  key: string,
     *  name: string,
     *  description: string
     * }
     */
    public function jsonSerialize(): array
    {
        return [
            'key' => $this->key,
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}
