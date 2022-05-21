<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall\Enums;

use NorseBlue\Heimdall\Contracts\DefinesEntity;
use NorseBlue\Heimdall\Contracts\DefinesPermission;
use NorseBlue\Heimdall\Contracts\DefinesRole;

enum EntityType: string
{
case Permission = 'permission';
case Role = 'role';

    /**
     * @return class-string<DefinesEntity>
     */
    public function definitionType(): string
    {
        return match ($this) {
            self::Permission => DefinesPermission::class,
            self::Role => DefinesRole::class,
        };
    }
    }
