<?php

declare(strict_types=1);

use function NorseBlue\Heimdall\Tests\createTestPermissions;
use NorseBlue\Heimdall\Tests\Fixtures\UserWithPermissions;
use function NorseBlue\Heimdall\Tests\setUpDatabaseForPermissions;

it('handles permissions correctly', function () {
    setUpDatabaseForPermissions($this->app);
    createTestPermissions(3);
    
    $user = UserWithPermissions::create([
        'email' => 'dev@norse.blue',
        'permissions' => ['test-permission-1', 'test-permission-2', 'nonexistent-permission'],
    ]);

    $this->assertTrue($user->hasPermission('test-permission-1'));
    $this->assertTrue($user->hasPermission('test-permission-2'));
    $this->assertFalse($user->hasPermission('test-permission-3'));
    $this->assertFalse($user->hasPermission('nonexistent-permission'));
});
