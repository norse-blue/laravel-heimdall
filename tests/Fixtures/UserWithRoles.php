<?php

declare(strict_types=1);

namespace NorseBlue\Heimdall\Tests\Fixtures;

use Illuminate\Foundation\Auth\User as Authenticatable;
use NorseBlue\Heimdall\Concerns\HasRoles;

class UserWithRoles extends Authenticatable
{
    use HasRoles;

    protected $table = 'users';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
