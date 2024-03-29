<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall\Registrar;

use InvalidArgumentException;
use NorseBlue\Heimdall\Contracts\DefinesEntity;
use NorseBlue\Heimdall\Entity;
use NorseBlue\Heimdall\Permissions\DefinedPermission;
use NorseBlue\Heimdall\Roles\DefinedRole;

/**
 * @template T
 */
abstract class BaseRegistrar
{
    /**
     * @var array<string, T>
     */
    protected array $items = [];

    public function __construct()
    {
    }

    /**
     * @return array<string>
     */
    public function all(): array
    {
        return $this->filterValid(['*']);
    }

    /**
     * @param  class-string<T>|DefinesEntity|Entity  $item
     * @return T
     */
    public function attach(string|DefinesEntity|Entity $item): mixed
    {
        if (is_string($item)) {
            if (! is_subclass_of($item, $this->getDefinitionType())) {
                throw new InvalidArgumentException(
                    "The class $item is not of type ".$this->getDefinitionType().'.'
                );
            }

            return $this->create(...$item::definition());
        }

        if (! is_a($item, $this->getType(), true)) {
            throw new InvalidArgumentException('The given item is not of type '.$this->getType().'.');
        }

        return $this->items[(string) $item->key] = $item;
    }

    public function clear(): void
    {
        $this->items = [];
    }

    public function computeKey(string $key): string
    {
        if (is_subclass_of($key, $this->getDefinitionType())) {
            /** @var DefinedPermission|DefinedRole $key */
            return $key::key();
        }

        return $key;
    }

    /**
     * @param  array<string>  $keys
     * @return array<string>
     */
    public function computeKeys(array $keys): array
    {
        $computed = [];
        foreach ($keys as $key) {
            $computed[] = $this->computeKey($key);
        }

        return $computed;
    }

    public function count(): int
    {
        return count($this->items);
    }

    /**
     * @param  array<string>  $items
     * @return array<string>
     */
    abstract public function filterValid(array $items): array;

    /**
     * @return T|null
     */
    public function find(string $key): mixed
    {
        return $this->items[$this->computeKey($key)] ?? null;
    }

    public function has(string $key): bool
    {
        return $this->find($this->computeKey($key)) !== null;
    }

    public function isEmpty(): bool
    {
        return $this->count() === 0;
    }

    /**
     * @return T
     */
    abstract protected function create(string $key, string $name, string $description = ''): mixed;

    /**
     * @return class-string<DefinesEntity>
     */
    abstract protected function getDefinitionType(): string;

    /**
     * @return class-string<T>
     */
    abstract protected function getType(): string;
}
