<?php

declare(strict_types=1);

use NorseBlue\Heimdall\Role;
use NorseBlue\Heimdall\Roles\AdminRole;
use function Pest\Laravel\mock;

it('can create a defined admin role permission', function () {
    mock('translator', function ($mock) {
        $mock->shouldReceive('get')->andReturnUsing(fn ($text) => $text);
        $mock->shouldReceive('trans')->andReturnUsing(fn ($text) => $text);
    });

    $role = new AdminRole();

    $this->assertInstanceOf(Role::class, $role);
    $this->assertEquals(AdminRole::definition(), $role->jsonSerialize());
});
