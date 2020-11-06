<?php

declare(strict_types=1);

use function NorseBlue\Heimdall\Tests\createTestRoles;
use NorseBlue\Heimdall\Tests\Fixtures\UserWithRoles;
use function NorseBlue\Heimdall\Tests\setUpDatabaseForRoles;

it('handles non initialized roles correctly', function () {
    setUpDatabaseForRoles($this->app);
    createTestRoles(3);

    $user = UserWithRoles::create([
        'email' => 'dev@norse.blue',
    ]);

    $this->assertEquals([], $user->roles);
});

it('handles empty roles correctly', function () {
    setUpDatabaseForRoles($this->app);
    createTestRoles(3);

    $user = UserWithRoles::create([
        'email' => 'dev@norse.blue',
        'roles' => [],
    ]);

    $this->assertEquals([], $user->roles);
});
it('handles roles correctly', function () {
    setUpDatabaseForRoles($this->app);
    createTestRoles(3);

    $user = UserWithRoles::create([
        'email' => 'dev@norse.blue',
        'roles' => ['test-role-1', 'test-role-2', 'nonexistent-role'],
    ]);

    $this->assertTrue($user->hasRole('test-role-1'));
    $this->assertTrue($user->hasRole('test-role-2'));
    $this->assertFalse($user->hasRole('test-role-3'));
    $this->assertFalse($user->hasRole('nonexistent-role'));

    $this->assertTrue($user->hasPermission('test-permission-1'));
    $this->assertTrue($user->hasPermission('test-permission-2'));
    $this->assertFalse($user->hasPermission('test-permission-3'));
    $this->assertFalse($user->hasPermission('nonexistent-permission'));
});
