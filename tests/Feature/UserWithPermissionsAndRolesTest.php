<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Gate;
use NorseBlue\Heimdall\AppRoles;
use NorseBlue\Heimdall\Tests\Fixtures\UserWithPermissionsAndRoles;
use function NorseBlue\Heimdall\Tests\createTestPermissions;
use function NorseBlue\Heimdall\Tests\createTestRoles;
use function NorseBlue\Heimdall\Tests\setUpDatabaseForPermissionsAndRoles;

it('handles permissions correctly', function () {
    setUpDatabaseForPermissionsAndRoles($this->app);
    createTestPermissions(3);

    $user = UserWithPermissionsAndRoles::create([
        'email' => 'dev@norse.blue',
        'permissions' => ['test-permission-1', 'test-permission-2', 'nonexistent-permission'],
    ]);

    $this->assertEquals(['test-permission-1', 'test-permission-2'], $user->permissions);

    $this->assertTrue($user->hasPermission('test-permission-1'));
    $this->assertTrue($user->hasPermission('test-permission-2'));
    $this->assertFalse($user->hasPermission('test-permission-3'));
    $this->assertFalse($user->hasPermission('nonexistent-permission'));

    $this->assertTrue(Gate::forUser($user)->allows('test-permission-1'));
    $this->assertTrue(Gate::forUser($user)->allows('test-permission-2'));
    $this->assertFalse(Gate::forUser($user)->allows('test-permission-3'));
    $this->assertFalse(Gate::forUser($user)->allows('nonexistent-permission'));

    $this->assertFalse(Gate::forUser($user)->denies('test-permission-1'));
    $this->assertFalse(Gate::forUser($user)->denies('test-permission-2'));
    $this->assertTrue(Gate::forUser($user)->denies('test-permission-3'));
    $this->assertTrue(Gate::forUser($user)->denies('nonexistent-permission'));
});

it('handles roles correctly', function () {
    setUpDatabaseForPermissionsAndRoles($this->app);
    createTestRoles(3);

    $user = UserWithPermissionsAndRoles::create([
        'email' => 'dev@norse.blue',
        'roles' => ['test-role-1', 'test-role-2', 'nonexistent-role'],
    ]);

    $this->assertEquals(['test-role-1', 'test-role-2'], $user->roles);

    $this->assertTrue($user->hasRole('test-role-1'));
    $this->assertTrue($user->hasRole('test-role-2'));
    $this->assertFalse($user->hasRole('test-role-3'));
    $this->assertFalse($user->hasRole('nonexistent-role'));

    $this->assertEquals([], $user->permissions);
    $this->assertEquals(['test-permission-1', 'test-permission-2'], $user->roles_permissions);

    $this->assertTrue($user->hasPermission('test-permission-1'));
    $this->assertTrue($user->hasPermission('test-permission-2'));
    $this->assertFalse($user->hasPermission('test-permission-3'));
    $this->assertFalse($user->hasPermission('nonexistent-permission'));

    $this->assertTrue(Gate::forUser($user)->allows('test-permission-1'));
    $this->assertTrue(Gate::forUser($user)->allows('test-permission-2'));
    $this->assertFalse(Gate::forUser($user)->allows('test-permission-3'));
    $this->assertFalse(Gate::forUser($user)->allows('nonexistent-permission'));

    $this->assertFalse(Gate::forUser($user)->denies('test-permission-1'));
    $this->assertFalse(Gate::forUser($user)->denies('test-permission-2'));
    $this->assertTrue(Gate::forUser($user)->denies('test-permission-3'));
    $this->assertTrue(Gate::forUser($user)->denies('nonexistent-permission'));
});

it('handles permissions and roles correctly', function () {
    setUpDatabaseForPermissionsAndRoles($this->app);
    createTestPermissions(3);
    createTestRoles(3, 4);      // Also creates test-permission-4, test-permission-5 and test-permission-6

    $user = UserWithPermissionsAndRoles::create([
        'email' => 'dev@norse.blue',
        'permissions' => ['test-permission-1', 'test-permission-2', 'nonexistent-permission'],
        'roles' => ['test-role-4', 'test-role-5', 'nonexistent-role'],
    ]);

    $this->assertEquals(['test-permission-1', 'test-permission-2'], $user->permissions);
    $this->assertEquals(['test-permission-4', 'test-permission-5'], $user->roles_permissions);
    $this->assertEquals(['test-permission-1', 'test-permission-2', 'test-permission-4', 'test-permission-5'], $user->all_permissions);

    $this->assertTrue($user->hasPermission('test-permission-1'));
    $this->assertTrue($user->hasPermission('test-permission-2'));
    $this->assertFalse($user->hasPermission('test-permission-3'));
    $this->assertTrue($user->hasPermission('test-permission-4'));
    $this->assertTrue($user->hasPermission('test-permission-5'));
    $this->assertFalse($user->hasPermission('test-permission-6'));
    $this->assertFalse($user->hasPermission('nonexistent-permission'));

    $this->assertTrue($user->hasRole('test-role-4'));
    $this->assertTrue($user->hasRole('test-role-5'));
    $this->assertFalse($user->hasRole('test-role-6'));

    $this->assertTrue(Gate::forUser($user)->allows('test-permission-1'));
    $this->assertTrue(Gate::forUser($user)->allows('test-permission-2'));
    $this->assertFalse(Gate::forUser($user)->allows('test-permission-3'));
    $this->assertTrue(Gate::forUser($user)->allows('test-permission-4'));
    $this->assertTrue(Gate::forUser($user)->allows('test-permission-5'));
    $this->assertFalse(Gate::forUser($user)->allows('test-permission-6'));
    $this->assertFalse(Gate::forUser($user)->allows('nonexistent-permission'));

    $this->assertFalse(Gate::forUser($user)->denies('test-permission-1'));
    $this->assertFalse(Gate::forUser($user)->denies('test-permission-2'));
    $this->assertTrue(Gate::forUser($user)->denies('test-permission-3'));
    $this->assertFalse(Gate::forUser($user)->denies('test-permission-4'));
    $this->assertFalse(Gate::forUser($user)->denies('test-permission-5'));
    $this->assertTrue(Gate::forUser($user)->denies('test-permission-6'));
    $this->assertTrue(Gate::forUser($user)->denies('nonexistent-permission'));
});

it('handles wildcard permission correctly', function () {
    setUpDatabaseForPermissionsAndRoles($this->app);
    createTestPermissions(3);
    createTestRoles(3, 4);      // Also creates test-permission-4, test-permission-5 and test-permission-6

    $user = UserWithPermissionsAndRoles::create([
        'email' => 'dev@norse.blue',
        'permissions' => ['*'],
        'roles' => ['test-role-1'],
    ]);

    $this->assertEquals(['*'], $user->permissions);
    $this->assertEquals(['test-permission-1'], $user->roles_permissions);
    $this->assertEquals(['*'], $user->all_permissions);

    $this->assertTrue($user->hasPermission('test-permission-1'));
    $this->assertTrue($user->hasPermission('test-permission-2'));
    $this->assertTrue($user->hasPermission('test-permission-3'));
    $this->assertTrue($user->hasPermission('test-permission-4'));
    $this->assertTrue($user->hasPermission('test-permission-5'));
    $this->assertTrue($user->hasPermission('test-permission-6'));
    $this->assertFalse($user->hasPermission('nonexistent-permission'));

    $this->assertTrue(Gate::forUser($user)->allows('test-permission-1'));
    $this->assertTrue(Gate::forUser($user)->allows('test-permission-2'));
    $this->assertTrue(Gate::forUser($user)->allows('test-permission-3'));
    $this->assertTrue(Gate::forUser($user)->allows('test-permission-4'));
    $this->assertTrue(Gate::forUser($user)->allows('test-permission-5'));
    $this->assertTrue(Gate::forUser($user)->allows('test-permission-6'));
    $this->assertFalse(Gate::forUser($user)->allows('nonexistent-permission'));

    $this->assertFalse(Gate::forUser($user)->denies('test-permission-1'));
    $this->assertFalse(Gate::forUser($user)->denies('test-permission-2'));
    $this->assertFalse(Gate::forUser($user)->denies('test-permission-3'));
    $this->assertFalse(Gate::forUser($user)->denies('test-permission-4'));
    $this->assertFalse(Gate::forUser($user)->denies('test-permission-5'));
    $this->assertFalse(Gate::forUser($user)->denies('test-permission-6'));
    $this->assertTrue(Gate::forUser($user)->denies('nonexistent-permission'));
});

it('handles wildcard permission from role correctly', function () {
    setUpDatabaseForPermissionsAndRoles($this->app);
    createTestPermissions(3);
    createTestRoles(3, 4);      // Also creates test-permission-4, test-permission-5 and test-permission-6
    AppRoles::create('wildcard','Wildcard Role', ['*']);

    $user = UserWithPermissionsAndRoles::create([
        'email' => 'dev@norse.blue',
        'permissions' => ['test-permission-1'],
        'roles' => ['wildcard'],
    ]);

    $this->assertEquals(['test-permission-1'], $user->permissions);
    $this->assertEquals(['*'], $user->roles_permissions);
    $this->assertEquals(['*'], $user->all_permissions);

    $this->assertTrue($user->hasPermission('test-permission-1'));
    $this->assertTrue($user->hasPermission('test-permission-2'));
    $this->assertTrue($user->hasPermission('test-permission-3'));
    $this->assertTrue($user->hasPermission('test-permission-4'));
    $this->assertTrue($user->hasPermission('test-permission-5'));
    $this->assertTrue($user->hasPermission('test-permission-6'));
    $this->assertFalse($user->hasPermission('nonexistent-permission'));

    $this->assertTrue(Gate::forUser($user)->allows('test-permission-1'));
    $this->assertTrue(Gate::forUser($user)->allows('test-permission-2'));
    $this->assertTrue(Gate::forUser($user)->allows('test-permission-3'));
    $this->assertTrue(Gate::forUser($user)->allows('test-permission-4'));
    $this->assertTrue(Gate::forUser($user)->allows('test-permission-5'));
    $this->assertTrue(Gate::forUser($user)->allows('test-permission-6'));
    $this->assertFalse(Gate::forUser($user)->allows('nonexistent-permission'));

    $this->assertFalse(Gate::forUser($user)->denies('test-permission-1'));
    $this->assertFalse(Gate::forUser($user)->denies('test-permission-2'));
    $this->assertFalse(Gate::forUser($user)->denies('test-permission-3'));
    $this->assertFalse(Gate::forUser($user)->denies('test-permission-4'));
    $this->assertFalse(Gate::forUser($user)->denies('test-permission-5'));
    $this->assertFalse(Gate::forUser($user)->denies('test-permission-6'));
    $this->assertTrue(Gate::forUser($user)->denies('nonexistent-permission'));
});
