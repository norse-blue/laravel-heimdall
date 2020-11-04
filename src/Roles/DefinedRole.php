<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall\Roles;

use NorseBlue\Heimdall\Contracts\DefinesRole;
use NorseBlue\Heimdall\Role;

abstract class DefinedRole extends Role implements DefinesRole
{
    public function __construct()
    {
        parent::__construct(...array_values(static::definition()));
    }
}
