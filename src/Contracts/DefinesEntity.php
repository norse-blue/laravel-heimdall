<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall\Contracts;

interface DefinesEntity
{
    /**
     * @return string
     */
    public static function key(): string;

    /**
     * @return array<string, mixed>
     */
    public static function definition(): array;
}
