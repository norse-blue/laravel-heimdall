<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall\Permissions;

use NorseBlue\Heimdall\Contracts\DefinesPermission;
use NorseBlue\Heimdall\Permission;

abstract class DefinedPermission extends Permission implements DefinesPermission
{
    public function __construct()
    {
        parent::__construct(...array_values(static::definition()));
    }
}
