<?php

declare(strict_types=1);

use NorseBlue\Heimdall\AppPermissions;
use NorseBlue\Heimdall\Permission;
use NorseBlue\Heimdall\Permissions\Admin\Dashboard\DashboardShowPermission;

it('can clear permissions', function () {
    AppPermissions::clear();
    $this->assertTrue(AppPermissions::isEmpty());

    AppPermissions::create('test-permission', 'Test permission', 'This is a test permission.');
    $this->assertFalse(AppPermissions::isEmpty());

    AppPermissions::clear();
    $this->assertTrue(AppPermissions::isEmpty());
});

it('can attach a permission', function () {
    AppPermissions::clear();

    $permission = tap(
        new Permission('test-permission', 'Test permission', 'This is a test permission.'),
        static fn ($permission) => AppPermissions::attach($permission)
    );

    $this->assertTrue(AppPermissions::has($permission->key));
    $this->assertEquals($permission, AppPermissions::find($permission->key));
});

it('can attach a defined permission', function () {
    AppPermissions::clear();

    $role = AppPermissions::attach(DashboardShowPermission::class);

    $this->assertTrue(AppPermissions::has($role->key));
    $this->assertEquals($role, AppPermissions::find($role->key));
});

it('throws an exception when trying to attach an invalid string value', function () {
    $this->expectException(InvalidArgumentException::class);

    AppPermissions::attach('NorseBlue\Heimdall\InvalidDefinedRole');
});

it('throws an exception when trying to attach an invalid object value', function () {
    $this->expectException(TypeError::class);

    AppPermissions::attach(new stdClass());
});

it('can create a permission', function () {
    AppPermissions::clear();

    $permission = AppPermissions::create('test-permission', 'Test permission', 'This is a test permission.');

    $this->assertTrue(AppPermissions::has($permission->key));
    $this->assertEquals($permission, AppPermissions::find($permission->key));
});

it('returns all available permissions', function () {
    AppPermissions::clear();

    AppPermissions::create('test-permission-1', 'Test permission 1');
    AppPermissions::create('test-permission-2', 'Test permission 2');
    AppPermissions::create('test-permission-3', 'Test permission 3');

    $this->assertEquals(3, AppPermissions::count());
    $this->assertEquals([
        'test-permission-1', 'test-permission-2', 'test-permission-3',
    ], AppPermissions::all());
    $this->assertEquals([
        'test-permission-1', 'test-permission-2', 'test-permission-3',
    ], AppPermissions::valid(['*']));
});

it('returns valid permissions', function () {
    AppPermissions::clear();

    AppPermissions::create('test-permission-1', 'Test permission 1');
    AppPermissions::create('test-permission-2', 'Test permission 2');
    AppPermissions::create('test-permission-3', 'Test permission 3');

    $this->assertEquals(3, AppPermissions::count());
    $this->assertEquals([
        'test-permission-1', 'test-permission-2',
    ], AppPermissions::valid([
        'test-permission-1', 'test-permission-2',
    ]));
    $this->assertEquals([
        'test-permission-1',
    ], AppPermissions::valid([
        'test-permission-1', 'nonexistent-test-permission',
    ]));
});
