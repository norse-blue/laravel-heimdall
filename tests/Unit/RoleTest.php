<?php

declare(strict_types=1);

use NorseBlue\Heimdall\Role;

it('can retrieve properties', function () {
    $role = new Role(
        'test',
        'Test role',
        ['permission-1', 'permission-2', 'permission-3'],
        'This is a test role'
    );

    $this->assertEquals('test', $role->key);
    $this->assertEquals('Test role', $role->name);
    $this->assertEquals('This is a test role', $role->description);
    $this->assertEquals(['permission-1', 'permission-2', 'permission-3'], $role->permissions);
});

it('serializes to json', function () {
    $role = new Role(
        'test',
        'Test role',
        ['permission-1', 'permission-2', 'permission-3'],
        'This is a test role'
    );

    $this->assertEquals([
        'key' => $role->key,
        'name' => $role->name,
        'description' => $role->description,
        'permissions' => $role->permissions,
    ], $role->jsonSerialize());
});
