<?php

declare(strict_types=1);

use NorseBlue\Heimdall\AppRoles;
use NorseBlue\Heimdall\Role;

it('can clear roles', function () {
    AppRoles::clear();
    $this->assertTrue(AppRoles::empty());
    
    AppRoles::create('test-role', 'Test role', [], 'This is a test role');
    $this->assertFalse(AppRoles::empty());
    
    AppRoles::clear();
    $this->assertTrue(AppRoles::empty());
});

it('can attach a role', function () {
    AppRoles::clear();
    
    $role = tap(
        new Role('test-role', 'Test role', [], 'This is a test role.'),
        static fn ($role) => AppRoles::attach($role)
    );
    
    $this->assertTrue(AppRoles::has($role->key));
    $this->assertEquals($role, AppRoles::find($role->key));
});

it('can create a role', function () {
    AppRoles::clear();
    
    $role = AppRoles::create('test-role', 'Test role', [], 'This is a test role.');

    $this->assertTrue(AppRoles::has($role->key));
    $this->assertEquals($role, AppRoles::find($role->key));
});

it('returns all available roles', function () {
    AppRoles::clear();
    
    AppRoles::create('test-role-1', 'Test role 1', ['permission-1.1', 'permission-1.2']);
    AppRoles::create('test-role-2', 'Test role 2', ['permission-2.1']);
    AppRoles::create('test-role-3', 'Test role 3', ['permission-3.1', 'permission-3.2', 'permission-3.3']);
    
    $this->assertEquals(3, AppRoles::count());
    $this->assertEquals(['test-role-1', 'test-role-2', 'test-role-3'], AppRoles::all());
    $this->assertEquals([
        'test-role-1' => ['permission-1.1', 'permission-1.2'],
        'test-role-2' => ['permission-2.1'],
        'test-role-3' => ['permission-3.1', 'permission-3.2', 'permission-3.3'],
    ], AppRoles::all(true));
    $this->assertEquals(['test-role-1', 'test-role-2', 'test-role-3'], AppRoles::valid(['*']));
    $this->assertEquals([
        'test-role-1' => ['permission-1.1', 'permission-1.2'],
        'test-role-2' => ['permission-2.1'],
        'test-role-3' => ['permission-3.1', 'permission-3.2', 'permission-3.3'],
    ], AppRoles::valid(['*'], true));
});

it('returns valid roles', function () {
    AppRoles::clear();
    
    AppRoles::create('test-role-1', 'Test role 1', ['permission-1.1', 'permission-1.2']);
    AppRoles::create('test-role-2', 'Test role 2', ['permission-2.1']);
    AppRoles::create('test-role-3', 'Test role 3', ['permission-3.1', 'permission-3.2', 'permission-3.3']);
    
    $this->assertEquals(3, AppRoles::count());
    $this->assertEquals(['test-role-1', 'test-role-2'], AppRoles::valid(['test-role-1', 'test-role-2']));
    $this->assertEquals([
        'test-role-1' => ['permission-1.1', 'permission-1.2'],
        'test-role-2' => ['permission-2.1'],
    ], AppRoles::valid(['test-role-1', 'test-role-2'], true));
    $this->assertEquals(['test-role-1'], AppRoles::valid(['test-role-1', 'test-role-missing']));
    $this->assertEquals([
        'test-role-1' => ['permission-1.1', 'permission-1.2'],
    ], AppRoles::valid([
        'test-role-1', 'test-role-missing',
    ], true));
});
