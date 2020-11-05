<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall\Contracts;

interface DefinesPermission extends DefinesEntity
{
    /**
     * @return array<string, string>{
     *  key: string,
     *  name: string,
     *  description: string,
     * }
     */
    public static function definition(): array;
}
