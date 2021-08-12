<?php

return [

    /*
    |--------------------------------------------------------------------------
    | The list of permissions configured by default
    |--------------------------------------------------------------------------
    |
    | This is the list of application permissions that should be loaded by default.
    | Each entry should be an array containing the key and the name. Optionally,
    | you can also set the permission description. Note that you can omit the
    | keys in the array, but either way the order matters.
    |
    | You can also specify a full qualified class name of a permission class that
    | inherits from NorseBlue\Heimdall\DefinedPermission that defines the permission.
    |
    | E.g.
    | ['key' => 'create-posts', 'name' => 'Create posts']
    | or
    | ['create-posts', 'Create posts']
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
    | Each entry should be an array containing the key, the name and the
    | permissions that the role has. Optionally, you can also set the role
    | description. Note that you can omit the keys in the array, but either
    | way the order matters.
    |
    | You can also specify a full qualified class name of a role class that
    | inherits from NorseBlue\Heimdall\DefinedRole that defines the role.
    |
    | E.g.
    | ['key' => 'posts-editor', 'name' => 'Posts editor', 'permissions' => ['edit-posts', 'delete-posts']]
    | or
    | ['posts-editor', 'Posts editor', ['edit-posts', 'delete-posts']]
    } or
    | ['key' => 'posts-editor', 'name' => 'Posts editor', 'permissions' => ['edit-posts', 'delete-posts'], 'description' => 'This role is for users that are posts editors']
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
    | The default column names of the models to store the permissions and roles.
    | This can be overridden in a per model basis.
    |
    */

    'column_names' => [

        /**
         * The default permissions column name.
         */

        'permissions' => 'permissions',

        /**
         * The default roles column name.
         */

        'roles' => 'roles',

    ],
];
