<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall\Contracts;

interface DefinesRole extends DefinesEntity
{
    /**
     * @return array{
     *  key: string,
     *  name: string,
     *  permissions: array,
     *  description: string,
     * }
     */
    public static function definition(): array;
}
