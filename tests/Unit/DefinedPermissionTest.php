<?php

declare(strict_types=1);

use NorseBlue\Heimdall\Permission;
use NorseBlue\Heimdall\Permissions\Admin\Dashboard\DashboardShowPermission;
use NorseBlue\Heimdall\Permissions\Admin\Users\UsersCreatePermission;
use NorseBlue\Heimdall\Permissions\Admin\Users\UsersDestroyPermission;
use NorseBlue\Heimdall\Permissions\Admin\Users\UsersEditPermission;
use NorseBlue\Heimdall\Permissions\Admin\Users\UsersListPermission;
use NorseBlue\Heimdall\Permissions\Admin\Users\UsersShowPermission;
use function Pest\Laravel\mock;

it('can create a defined admin dashboard show permission', function () {
    mock('translator', function ($mock) {
        $mock->shouldReceive('get')->andReturnUsing(fn ($text) => $text);
        $mock->shouldReceive('trans')->andReturnUsing(fn ($text) => $text);
    });

    $permission = new DashboardShowPermission();

    $this->assertInstanceOf(Permission::class, $permission);
    $this->assertEquals(DashboardShowPermission::definition(), $permission->jsonSerialize());
});

it('can create a defined admin users create permission', function () {
    mock('translator', function ($mock) {
        $mock->shouldReceive('get')->andReturnUsing(fn ($text) => $text);
        $mock->shouldReceive('trans')->andReturnUsing(fn ($text) => $text);
    });
    $permission = new UsersCreatePermission();

    $this->assertInstanceOf(Permission::class, $permission);
    $this->assertEquals(UsersCreatePermission::definition(), $permission->jsonSerialize());
});

it('can create a defined admin users destroy permission', function () {
    mock('translator', function ($mock) {
        $mock->shouldReceive('get')->andReturnUsing(fn ($text) => $text);
        $mock->shouldReceive('trans')->andReturnUsing(fn ($text) => $text);
    });
    $permission = new UsersDestroyPermission();

    $this->assertInstanceOf(Permission::class, $permission);
    $this->assertEquals(UsersDestroyPermission::definition(), $permission->jsonSerialize());
});

it('can create a defined admin users edit permission', function () {
    mock('translator', function ($mock) {
        $mock->shouldReceive('get')->andReturnUsing(fn ($text) => $text);
        $mock->shouldReceive('trans')->andReturnUsing(fn ($text) => $text);
    });
    $permission = new UsersEditPermission();

    $this->assertInstanceOf(Permission::class, $permission);
    $this->assertEquals(UsersEditPermission::definition(), $permission->jsonSerialize());
});

it('can create a defined admin users list permission', function () {
    mock('translator', function ($mock) {
        $mock->shouldReceive('get')->andReturnUsing(fn ($text) => $text);
        $mock->shouldReceive('trans')->andReturnUsing(fn ($text) => $text);
    });
    $permission = new UsersListPermission();

    $this->assertInstanceOf(Permission::class, $permission);
    $this->assertEquals(UsersListPermission::definition(), $permission->jsonSerialize());
});

it('can create a defined admin users show permission', function () {
    mock('translator', function ($mock) {
        $mock->shouldReceive('get')->andReturnUsing(fn ($text) => $text);
        $mock->shouldReceive('trans')->andReturnUsing(fn ($text) => $text);
    });
    $permission = new UsersShowPermission();

    $this->assertInstanceOf(Permission::class, $permission);
    $this->assertEquals(UsersShowPermission::definition(), $permission->jsonSerialize());
});
