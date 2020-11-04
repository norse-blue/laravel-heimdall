<?php

namespace NorseBlue\Heimdall\Tests;

use Illuminate\Database\Schema\Blueprint;
use NorseBlue\Heimdall\AppPermissions;
use NorseBlue\Heimdall\AppRoles;

function setUpDatabaseForPermissions($app): void
{
    $app['db']->connection()->getSchemaBuilder()->create('users', function (Blueprint $table) {
        $table->increments('id');
        $table->string('email');
        $table->json('permissions')->nullable();
        $table->timestamps();
    });
}

function setUpDatabaseForRoles($app): void
{
    $app['db']->connection()->getSchemaBuilder()->create('users', function (Blueprint $table) {
        $table->increments('id');
        $table->string('email');
        $table->json('roles')->nullable();
        $table->timestamps();
    });
}

function createTestPermissions(int $count): void
{
    AppPermissions::clear();
    foreach (range(1, $count) as $permission_index) {
        AppPermissions::create("test-permission-{$permission_index}", "Test permission {$permission_index}");
    }
}

function createTestRoles(int $count): void
{
    createTestPermissions($count);
    
    AppRoles::clear();
    foreach (range(1, $count) as $role_index) {
        $permissions = [];
        foreach (range(1, $role_index) as $permission_index) {
            $permissions[] = "test-permission-{$permission_index}";
        }
        AppRoles::create("test-role-{$role_index}", "Test role {$role_index}", $permissions);
    }
}
