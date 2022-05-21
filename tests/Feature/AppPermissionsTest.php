<?php

declare(strict_types=1);

use NorseBlue\Heimdall\Facades\Registrar;
use NorseBlue\Heimdall\Permission;
use NorseBlue\Heimdall\Permissions\Admin\Dashboard\DashboardShowPermission;

it('can clear permissions', function () {
    Registrar::permissions()->clear();
    $this->assertTrue(Registrar::permissions()->isEmpty());

    Registrar::permissions()->create('test-permission', 'Test permission', 'This is a test permission.');
    $this->assertFalse(Registrar::permissions()->isEmpty());

    Registrar::permissions()->clear();
    $this->assertTrue(Registrar::permissions()->isEmpty());
});

it('can attach a permission', function () {
    Registrar::permissions()->clear();

    $permission = tap(
        new Permission('test-permission', 'Test permission', 'This is a test permission.'),
        static fn ($permission) => Registrar::permissions()->attach($permission)
    );

    $this->assertTrue(Registrar::permissions()->has($permission->key));
    $this->assertEquals($permission, Registrar::permissions()->find($permission->key));
});

it('can attach a defined permission', function () {
    Registrar::permissions()->clear();

    $role = Registrar::permissions()->attach(DashboardShowPermission::class);

    $this->assertTrue(Registrar::permissions()->has($role->key));
    $this->assertEquals($role, Registrar::permissions()->find($role->key));
});

it('throws an exception when trying to attach an invalid string value', function () {
    $this->expectException(InvalidArgumentException::class);

    Registrar::permissions()->attach('NorseBlue\Heimdall\InvalidDefinedRole');
});

it('throws an exception when trying to attach an invalid object value', function () {
    $this->expectException(InvalidArgumentException::class);

    Registrar::permissions()->attach(new stdClass());
});

it('can create a permission', function () {
    Registrar::permissions()->clear();

    $permission = Registrar::permissions()->create('test-permission', 'Test permission', 'This is a test permission.');

    $this->assertTrue(Registrar::permissions()->has($permission->key));
    $this->assertEquals($permission, Registrar::permissions()->find($permission->key));
});

it('returns all available permissions', function () {
    Registrar::permissions()->clear();

    Registrar::permissions()->create('test-permission-1', 'Test permission 1');
    Registrar::permissions()->create('test-permission-2', 'Test permission 2');
    Registrar::permissions()->create('test-permission-3', 'Test permission 3');

    $this->assertEquals(3, Registrar::permissions()->count());
    $this->assertEquals([
        'test-permission-1',
        'test-permission-2',
        'test-permission-3',
    ], Registrar::permissions()->all());
    $this->assertEquals([
        'test-permission-1',
        'test-permission-2',
        'test-permission-3',
    ], Registrar::permissions()->filterValid(['*']));
});

it('returns valid permissions', function () {
    Registrar::permissions()->clear();

    Registrar::permissions()->create('test-permission-1', 'Test permission 1');
    Registrar::permissions()->create('test-permission-2', 'Test permission 2');
    Registrar::permissions()->create('test-permission-3', 'Test permission 3');

    $this->assertEquals(3, Registrar::permissions()->count());
    $this->assertEquals(
        [
        'test-permission-1',
        'test-permission-2',
        ],
        Registrar::permissions()->filterValid([
            'test-permission-1',
            'test-permission-2',
        ])
    );
    $this->assertEquals(
        [
        'test-permission-1',
        ],
        Registrar::permissions()->filterValid([
            'test-permission-1',
            'nonexistent-test-permission',
        ])
    );
});
