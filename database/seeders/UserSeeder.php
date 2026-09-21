<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    // Pwd = Password!1
    private const PASSWORD_HASH = '$2y$12$j18cT3n2U/LXqK3Ea6tOC.Zg4vO2B4ql061P1S6wTuXC007.LaoDG';

    /**
     * @var list<array{name: string, first_name: string, last_name: string, email: string, role: string, theme: string}>
     */
    private const USERS = [
        ['name' => 'admin', 'first_name' => 'Faso', 'last_name' => 'Tuto', 'email' => 'admin@admin.com', 'role' => 'Admin', 'theme' => 'violet'],
    ];

    public function run(): void
    {
        foreach (self::USERS as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name'          => $data['name'],
                    'first_name'    => $data['first_name'],
                    'last_name'     => $data['last_name'],
                    'password' => self::PASSWORD_HASH,
                    'theme'    => $data['theme'],
                    'font'     => 'inter',
                    'locale'   => 'it',
                ],
            );

            $user->forceFill(['email_verified_at' => $user->email_verified_at ?? now()])->save();
            $user->syncRoles($data['role']);
        }
    }
}
