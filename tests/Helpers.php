<?php

namespace NorseBlue\Heimdall\Tests;

use Illuminate\Database\Schema\Blueprint;
use NorseBlue\Heimdall\Facades\Registrar;

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

function setUpDatabaseForPermissionsAndRoles($app): void
{
    $app['db']->connection()->getSchemaBuilder()->create('users', function (Blueprint $table) {
        $table->increments('id');
        $table->string('email');
        $table->json('permissions')->nullable();
        $table->json('roles')->nullable();
        $table->timestamps();
    });
}

function clearAppPermissions(): void
{
    Registrar::permissions()->clear();
}

function createTestPermissions(int $count, $start_with = 1): void
{
    foreach (range($start_with, $start_with + $count - 1) as $permission_index) {
        Registrar::permissions()->create("test-permission-{$permission_index}", "Test permission {$permission_index}");
    }
}

function clearAppRoles(): void
{
    Registrar::roles()->clear();
}

function createTestRoles(int $count, $start_with = 1): void
{
    createTestPermissions($count, $start_with);

    foreach (range($start_with, $start_with + $count - 1) as $role_index) {
        $permissions = [];
        foreach (range($start_with, $role_index) as $permission_index) {
            $permissions[] = "test-permission-{$permission_index}";
        }
        Registrar::roles()->create("test-role-{$role_index}", "Test role {$role_index}", permissions: $permissions);
    }
}
