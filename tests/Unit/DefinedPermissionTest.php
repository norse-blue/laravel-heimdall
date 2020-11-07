<?php

declare(strict_types=1);

use NorseBlue\Heimdall\Permission;
use NorseBlue\Heimdall\Permissions\Admin\Dashboard\DashboardShowPermission;
use NorseBlue\Heimdall\Permissions\Admin\Users\UsersCreatePermission;
use function Pest\Laravel\mock;

it('can create a defined admin view dashboard permission', function () {
    mock('translator', function ($mock) {
        $mock->shouldReceive('get')->andReturnUsing(fn ($text) => $text);
        $mock->shouldReceive('trans')->andReturnUsing(fn ($text) => $text);
    });

    $permission = new DashboardShowPermission();

    $this->assertInstanceOf(Permission::class, $permission);
    $this->assertEquals(DashboardShowPermission::definition(), $permission->jsonSerialize());
});

it('can create a defined create users permission', function () {
    mock('translator', function ($mock) {
        $mock->shouldReceive('get')->andReturnUsing(fn ($text) => $text);
        $mock->shouldReceive('trans')->andReturnUsing(fn ($text) => $text);
    });
    $permission = new UsersCreatePermission();

    $this->assertInstanceOf(Permission::class, $permission);
    $this->assertEquals(UsersCreatePermission::definition(), $permission->jsonSerialize());
});
