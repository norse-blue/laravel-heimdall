<?php

return [

    /*
    |--------------------------------------------------------------------------
    | The list of permissions configured by default
    |--------------------------------------------------------------------------
    |
    | This is the list of application permissions that should be loaded by default.
    | Each entry should be an array containing at least the key and the name.
    | Optionally, you can also set the permission's description.
    |
    | You can also specify a full qualified class name of a permission class that
    | inherits from NorseBlue\Heimdall\DefinedPermission in which the permission
    | definition exists.
    |
    | E.g.
    | ['key' => 'create-posts', 'name' => 'Create posts']
    | or
    | ['key' => 'create-posts', 'name' => 'Create posts', 'description' => 'Allows to create posts']
    | or
    | NorseBlue\Heimdall\Permissions\Admin\UsersCreatePermission::class
    |
    */
    'permissions' => [
        //
    ],

    /*
    |--------------------------------------------------------------------------
    | The list of roles configured by default
    |--------------------------------------------------------------------------
    |
    | This is the list of application roles that should be loaded by default.
    | Each entry should be an array containing at least the key, the name and
    | the permissions that the role should have. Optionally, you can also set
    | the role's description.
    |
    | You can also specify a full qualified class name of a role class that
    | inherits from NorseBlue\Heimdall\DefinedRole that defines the role.
    |
    | E.g.
    | ['key' => 'posts-editor', 'name' => 'Posts editor', 'permissions' => ['edit-posts', 'delete-posts']]
    | or
    | ['key' => 'posts-editor', 'name' => 'Posts editor', 'permissions' => ['edit-posts', 'delete-posts'],
    |   'description' => 'This role is for users that are posts editors'
    | ]
    | or
    | NorseBlue\Heimdall\Roles\AdminRole::class
    |
    */
    'roles' => [
        //
    ],

    /*
    |--------------------------------------------------------------------------
    | The model's column names
    |--------------------------------------------------------------------------
    |
    | The default database column names for the models to store the permissions
    | and roles into. This can be overridden in a per model basis.
    |
    */

    'column_names' => [

        /**
         * The default permission's database column name.
         */
        'permissions' => 'permissions',

        /**
         * The default role's database column name.
         */
        'roles' => 'roles',

    ],
];
