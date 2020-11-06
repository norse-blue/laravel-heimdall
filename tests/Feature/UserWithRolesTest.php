<?php

declare(strict_types=1);

use NorseBlue\Heimdall\AppRoles;
use NorseBlue\Heimdall\Tests\Fixtures\UserWithRoles;
use function NorseBlue\Heimdall\Tests\clearAppRoles;
use function NorseBlue\Heimdall\Tests\createTestRoles;
use function NorseBlue\Heimdall\Tests\setUpDatabaseForRoles;

it('handles non initialized roles correctly', function () {
    setUpDatabaseForRoles($this->app);
    clearAppRoles();
    createTestRoles(3);

    $user = UserWithRoles::create([
        'email' => 'dev@norse.blue',
    ]);

    $this->assertEquals([], $user->roles);
});

it('handles empty roles correctly', function () {
    setUpDatabaseForRoles($this->app);
    clearAppRoles();
    createTestRoles(3);

    $user = UserWithRoles::create([
        'email' => 'dev@norse.blue',
        'roles' => [],
    ]);

    $this->assertEquals([], $user->roles);
});

it('handles roles correctly', function () {
    setUpDatabaseForRoles($this->app);
    clearAppRoles();
    createTestRoles(3);

    $user = UserWithRoles::create([
        'email' => 'dev@norse.blue',
        'roles' => ['test-role-1', 'test-role-2', 'nonexistent-role'],
    ]);

    $this->assertEquals(['test-role-1', 'test-role-2'], $user->roles);

    $this->assertTrue($user->hasRole('test-role-1'));
    $this->assertTrue($user->hasRole('test-role-2'));
    $this->assertFalse($user->hasRole('test-role-3'));
    $this->assertFalse($user->hasRole('nonexistent-role'));

    $this->assertEquals(['test-permission-1', 'test-permission-2'], $user->permissions);

    $this->assertTrue($user->hasPermission('test-permission-1'));
    $this->assertTrue($user->hasPermission('test-permission-2'));
    $this->assertFalse($user->hasPermission('test-permission-3'));
    $this->assertFalse($user->hasPermission('nonexistent-permission'));
});

it('handles wildcard permission from role correctly', function () {
    setUpDatabaseForRoles($this->app);
    clearAppRoles();
    createTestRoles(3);     // Also creates test-permission-1, test-permission-2 and test-permission-3
    AppRoles::create('wildcard','Wildcard Role', ['*']);

    $user = UserWithRoles::create([
        'email' => 'dev@norse.blue',
        'roles' => ['wildcard'],
    ]);

    $this->assertEquals(['*'], $user->permissions);

    $this->assertTrue($user->hasPermission('test-permission-1'));
    $this->assertTrue($user->hasPermission('test-permission-2'));
    $this->assertTrue($user->hasPermission('test-permission-3'));
    $this->assertFalse($user->hasPermission('nonexistent-permission'));
});
