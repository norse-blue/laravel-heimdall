<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall\Tests\Fixtures;

use Illuminate\Foundation\Auth\User as Authenticatable;

class UserWithRolesAndPermissions extends Authenticatable
{
    protected $table = 'users';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
