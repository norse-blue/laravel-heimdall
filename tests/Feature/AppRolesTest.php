<?php

declare(strict_types=1);

use NorseBlue\Heimdall\Facades\Registrar;
use NorseBlue\Heimdall\Role;
use NorseBlue\Heimdall\Roles\AdminRole;

it('can clear roles', function () {
    Registrar::roles()->clear();
    $this->assertTrue(Registrar::roles()->isEmpty());

    Registrar::roles()->create('test-role', 'Test role', 'This is a test role', []);
    $this->assertFalse(Registrar::roles()->isEmpty());

    Registrar::roles()->clear();
    $this->assertTrue(Registrar::roles()->isEmpty());
});

it('can attach a role', function () {
    Registrar::roles()->clear();

    $role = tap(
        new Role('test-role', 'Test role', 'This is a test role.', []),
        static fn ($role) => Registrar::roles()->attach($role)
    );

    $this->assertTrue(Registrar::roles()->has($role->key));
    $this->assertEquals($role, Registrar::roles()->find($role->key));
});

it('can attach a defined role', function () {
    Registrar::roles()->clear();

    $role = Registrar::roles()->attach(AdminRole::class);

    $this->assertTrue(Registrar::roles()->has($role->key));
    $this->assertEquals($role, Registrar::roles()->find($role->key));
});

it('throws an exception when trying to attach an invalid string value', function () {
    $this->expectException(InvalidArgumentException::class);

    Registrar::roles()->attach('NorseBlue\Heimdall\InvalidDefinedRole');
});

it('throws an exception when trying to attach an invalid object value', function () {
    $this->expectException(InvalidArgumentException::class);

    Registrar::roles()->attach(new stdClass());
});

it('can create a role', function () {
    Registrar::roles()->clear();

    $role = Registrar::roles()->create('test-role', 'Test role', 'This is a test role.', []);

    $this->assertTrue(Registrar::roles()->has($role->key));
    $this->assertEquals($role, Registrar::roles()->find($role->key));
});

it('returns all available roles', function () {
    Registrar::roles()->clear();

    Registrar::roles()->create('test-role-1', 'Test role 1', permissions: ['permission-1.1', 'permission-1.2']);
    Registrar::roles()->create('test-role-2', 'Test role 2', permissions: ['permission-2.1']);
    Registrar::roles()->create('test-role-3', 'Test role 3', permissions: ['permission-3.1', 'permission-3.2', 'permission-3.3']);

    $this->assertEquals(3, Registrar::roles()->count());
    $this->assertEquals(['test-role-1', 'test-role-2', 'test-role-3'], Registrar::roles()->all());
    $this->assertEquals([
        'test-role-1' => ['permission-1.1', 'permission-1.2'],
        'test-role-2' => ['permission-2.1'],
        'test-role-3' => ['permission-3.1', 'permission-3.2', 'permission-3.3'],
    ], Registrar::roles()->all(true));
    $this->assertEquals(['test-role-1', 'test-role-2', 'test-role-3'], Registrar::roles()->filterValid(['*']));
    $this->assertEquals([
        'test-role-1' => ['permission-1.1', 'permission-1.2'],
        'test-role-2' => ['permission-2.1'],
        'test-role-3' => ['permission-3.1', 'permission-3.2', 'permission-3.3'],
    ], Registrar::roles()->filterValid(['*'], true));
});

it('returns valid roles', function () {
    Registrar::roles()->clear();

    Registrar::roles()->create('test-role-1', 'Test role 1', permissions: ['permission-1.1', 'permission-1.2']);
    Registrar::roles()->create('test-role-2', 'Test role 2', permissions: ['permission-2.1']);
    Registrar::roles()->create('test-role-3', 'Test role 3', permissions: ['permission-3.1', 'permission-3.2', 'permission-3.3']);

    $this->assertEquals(3, Registrar::roles()->count());
    $this->assertEquals(['test-role-1', 'test-role-2'], Registrar::roles()->filterValid(['test-role-1', 'test-role-2']));
    $this->assertEquals([
        'test-role-1' => ['permission-1.1', 'permission-1.2'],
        'test-role-2' => ['permission-2.1'],
    ], Registrar::roles()->filterValid(['test-role-1', 'test-role-2'], true));
    $this->assertEquals(['test-role-1'], Registrar::roles()->filterValid(['test-role-1', 'test-role-missing']));
    $this->assertEquals(
        [
        'test-role-1' => ['permission-1.1', 'permission-1.2'],
        ],
        Registrar::roles()->filterValid(
            [
            'test-role-1',
            'test-role-missing',
            ],
            true
        )
    );
});
