<?php

declare(strict_types=1);

use NorseBlue\Heimdall\Tests\Fixtures\UserWithPermissions;
use function NorseBlue\Heimdall\Tests\clearAppPermissions;
use function NorseBlue\Heimdall\Tests\createTestPermissions;
use function NorseBlue\Heimdall\Tests\setUpDatabaseForPermissions;

it('handles non initialized permissions correctly', function () {
    setUpDatabaseForPermissions($this->app);
    clearAppPermissions();
    createTestPermissions(3);

    $user = UserWithPermissions::create([
        'email' => 'dev@norse.blue',
    ]);

    $this->assertEquals([], $user->permissions);
});

it('handles empty permissions correctly', function () {
    setUpDatabaseForPermissions($this->app);
    clearAppPermissions();
    createTestPermissions(3);

    $user = UserWithPermissions::create([
        'email' => 'dev@norse.blue',
        'permissions' => [],
    ]);

    $this->assertEquals([], $user->permissions);
});

it('handles permissions correctly', function () {
    setUpDatabaseForPermissions($this->app);
    clearAppPermissions();
    createTestPermissions(3);

    $user = UserWithPermissions::create([
        'email' => 'dev@norse.blue',
        'permissions' => ['test-permission-1', 'test-permission-2', 'nonexistent-permission'],
    ]);

    $this->assertEquals(['test-permission-1', 'test-permission-2'], $user->permissions);

    $this->assertTrue($user->hasPermission('test-permission-1'));
    $this->assertTrue($user->hasPermission('test-permission-2'));
    $this->assertFalse($user->hasPermission('test-permission-3'));
    $this->assertFalse($user->hasPermission('nonexistent-permission'));
});

it('handles wildcard permission correctly', function () {
    setUpDatabaseForPermissions($this->app);
    clearAppPermissions();
    createTestPermissions(3);

    $user = UserWithPermissions::create([
        'email' => 'dev@norse.blue',
        'permissions' => ['*'],
    ]);

    $this->assertEquals(['*'], $user->permissions);

    $this->assertTrue($user->hasPermission('test-permission-1'));
    $this->assertTrue($user->hasPermission('test-permission-2'));
    $this->assertTrue($user->hasPermission('test-permission-3'));
    $this->assertFalse($user->hasPermission('nonexistent-permission'));
});
