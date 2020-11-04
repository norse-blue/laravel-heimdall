<?php

declare(strict_types=1);

use NorseBlue\Heimdall\Permission;

it('can retrieve properties', function () {
    $permission = new Permission('test', 'Test permission', 'This is a test permission');

    $this->assertEquals('test', $permission->key);
    $this->assertEquals('Test permission', $permission->name);
    $this->assertEquals('This is a test permission', $permission->description);
});

it('serializes to json', function () {
    $permission = new Permission('test', 'Test permission', 'This is a test permission');

    $this->assertEquals([
        'key' => $permission->key,
        'name' => $permission->name,
        'description' => $permission->description,
    ], $permission->jsonSerialize());
});
