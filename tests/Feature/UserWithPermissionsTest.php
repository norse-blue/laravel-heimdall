<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Gate;
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

    $this->assertTrue(Gate::forUser($user)->allows('test-permission-1'));
    $this->assertTrue(Gate::forUser($user)->allows('test-permission-2'));
    $this->assertFalse(Gate::forUser($user)->allows('test-permission-3'));
    $this->assertFalse(Gate::forUser($user)->allows('nonexistent-permission'));

    $this->assertFalse(Gate::forUser($user)->denies('test-permission-1'));
    $this->assertFalse(Gate::forUser($user)->denies('test-permission-2'));
    $this->assertTrue(Gate::forUser($user)->denies('test-permission-3'));
    $this->assertTrue(Gate::forUser($user)->denies('nonexistent-permission'));
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

    $this->assertTrue(Gate::forUser($user)->allows('test-permission-1'));
    $this->assertTrue(Gate::forUser($user)->allows('test-permission-2'));
    $this->assertTrue(Gate::forUser($user)->allows('test-permission-3'));
    $this->assertFalse(Gate::forUser($user)->allows('nonexistent-permission'));

    $this->assertFalse(Gate::forUser($user)->denies('test-permission-1'));
    $this->assertFalse(Gate::forUser($user)->denies('test-permission-2'));
    $this->assertFalse(Gate::forUser($user)->denies('test-permission-3'));
    $this->assertTrue(Gate::forUser($user)->denies('nonexistent-permission'));
});
