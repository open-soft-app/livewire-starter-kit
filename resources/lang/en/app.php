<?php

declare(strict_types=1);

return [
    'dashboard' => [
        'welcome' => 'Welcome!',
    ],
    'sidebar' => [
        'dashboard'        => 'Dashboard',
        'users_management' => 'Users Management',
        'users'            => 'Users',
        'roles'            => 'Roles',
        'permissions'      => 'Permissions',
        'welcome_page'     => 'Welcome Page',
    ],
    'permissions' => [
        'id'           => '#',
        'name'         => 'Name',
        'guard'        => 'Guard',
        'created'      => 'Created',
        'create_new'   => 'Create New Permission',
        'update_title' => 'Update Permission: #:id',
        'save'         => 'Save',
    ],
    'roles' => [
        'id'                     => '#',
        'name'                   => 'Name',
        'created'                => 'Created',
        'create_new'             => 'Create New Role',
        'update_title'           => 'Update Role: #:id',
        'save'                   => 'Save',
        'cancel'                 => 'Cancel',
        'search'                 => 'Search',
        'permissions'            => 'Permissions',
        'no_permissions'         => 'No permissions available',
        'no_records'             => 'No records found',
        'manage_permissions'     => 'Manage Permissions for Role: :name',
        'select_all_permissions' => 'Select all permissions',
        'permissions_updated'    => 'Permissions updated successfully',
    ],
    'users' => [
        'id'               => '#',
        'name'             => 'Name',
        'first_name'       => 'First Name',
        'last_name'        => 'Last Name',
        'email'            => 'E-mail',
        'roles'            => 'Roles',
        'created'          => 'Created',
        'password'         => 'Password',
        'confirm_password' => 'Confirm Password',
        'password_hint'    => 'The password will only be updated if you set the value of this field',
        'create_new'       => 'Create New User',
        'update_title'     => 'Update User: #:id',
        'save'             => 'Save',
    ],
];
