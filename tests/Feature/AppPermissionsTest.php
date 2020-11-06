<?php

declare(strict_types=1);

use NorseBlue\Heimdall\AppPermissions;
use NorseBlue\Heimdall\Permission;

it('can clear permissions', function () {
    AppPermissions::clear();
    $this->assertTrue(AppPermissions::empty());

    AppPermissions::create('test-permission', 'Test permission', 'This is a test permission.');
    $this->assertFalse(AppPermissions::empty());

    AppPermissions::clear();
    $this->assertTrue(AppPermissions::empty());
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
