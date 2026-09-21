<?php

declare(strict_types=1);

return [
    'title' => 'Profile',
    'tabs'  => [
        'profile'    => 'Profile',
        'password'   => 'Password',
        'two_factor' => 'Two Factor Authentication',
    ],
    'information' => [
        'name'           => 'Name',
        'first_name'     => 'First Name',
        'last_name'      => 'Last Name',
        'email'          => 'Email',
        'theme'          => 'Theme',
        'font'           => 'Font',
        'assigned_roles' => 'Assigned Roles',
        'save'           => 'Save',
    ],
    'themes' => [
        'teal'    => 'Teal',
        'emerald' => 'Emerald',
        'cyan'    => 'Cyan',
        'violet'  => 'Violet',
    ],
    'delete' => [
        'delete_profile'   => 'Delete Profile',
        'confirm_message'  => 'Are you sure you want to delete your profile? This action cannot be undone.',
        'current_password' => 'Current Password',
        'cancel'           => 'Cancel',
        'delete'           => 'Delete',
    ],
    'password' => [
        'current_password' => 'Current Password',
        'new_password'     => 'New Password',
        'confirm_password' => 'Confirm Password',
        'save'             => 'Save',
    ],
    'recovery_codes' => [
        'title'       => 'Recovery Codes',
        'description' => 'Store these recovery codes in a secure password manager. They can be used to recover access to your account if your authenticator device is lost.',
        'refresh'     => 'Refresh Codes',
        'download'    => 'Download Codes',
        'close'       => 'Close',
    ],
    'two_factor' => [
        'enabled_message'  => 'Two-factor authentication is enabled on your account.',
        'pending_message'  => 'Scan the QR code with your authenticator app, then enter the 6-digit code to finish enabling two-factor authentication.',
        'description'      => 'When two-factor authentication is enabled, you will be prompted for a secure, random token during authentication. You can retrieve this token from your phone\'s Google Authenticator application.',
        'current_password' => 'Current Password',
        'show_codes'       => 'Show Recovery Codes',
        'setup_key'        => 'Setup key',
        'code'             => 'Authentication Code',
        'enable'           => 'Enable',
        'disable'          => 'Disable',
        'confirm'          => 'Confirm',
        'cancel'           => 'Cancel',
        'invalid_code'     => 'The provided two factor authentication code was invalid.',
    ],
    'attributes' => [
        'name'             => 'Name',
        'first_name'       => 'First Name',
        'last_name'        => 'Last Name',
        'theme'            => 'Theme',
        'font'             => 'Font',
        'password'         => 'password',
        'current_password' => 'current password',
        'code'             => 'authentication code',
    ],
];
