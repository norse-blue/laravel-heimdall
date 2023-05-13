<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall\Facades;

use Illuminate\Support\Facades\Facade;
use NorseBlue\Heimdall\Entity;
use NorseBlue\Heimdall\Enums\EntityType;
use NorseBlue\Heimdall\HeimdallServiceProvider;
use NorseBlue\Heimdall\Registrar\PermissionRegistrar;
use NorseBlue\Heimdall\Registrar\RoleRegistrar;

/**
 * @method static Entity create(EntityType $type, array $params)
 * @method static PermissionRegistrar permissions()
 * @method static RoleRegistrar roles()
 */
class Registrar extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return HeimdallServiceProvider::REGISTRAR_ALIAS;
    }
}
