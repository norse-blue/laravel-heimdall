<?php

declare(strict_types=1);

use NorseBlue\Heimdall\Permission;
use NorseBlue\Heimdall\Permissions\Admin\ViewDashboardPermission;
use NorseBlue\Heimdall\Permissions\Users\CreateUsersPermission;
use function Pest\Laravel\mock;

it('can create a defined admin view dashboard permission', function () {
    mock('translator', function ($mock) {
        $mock->shouldReceive('get')->andReturnUsing(fn ($text) => $text);
        $mock->shouldReceive('trans')->andReturnUsing(fn ($text) => $text);
    });

    $permission = new ViewDashboardPermission();

    $this->assertInstanceOf(Permission::class, $permission);
    $this->assertEquals(ViewDashboardPermission::definition(), $permission->jsonSerialize());
});

it('can create a defined create users permission', function () {
    mock('translator', function ($mock) {
        $mock->shouldReceive('get')->andReturnUsing(fn ($text) => $text);
        $mock->shouldReceive('trans')->andReturnUsing(fn ($text) => $text);
    });
    $permission = new CreateUsersPermission();

    $this->assertInstanceOf(Permission::class, $permission);
    $this->assertEquals(CreateUsersPermission::definition(), $permission->jsonSerialize());
});
