<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    private const GUARD = 'web';

    /**
     * @var list<string>
     */
    private const ACTIONS = ['create', 'read', 'update', 'delete'];

    /**
     * Risorse di amministrazione, riservate al ruolo Admin.
     *
     * @var list<string>
     */
    private const ADMIN_RESOURCES = [
        'users',
        'roles',
        'permissions',
    ];


    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $adminPermissions       = $this->createPermissions(self::ADMIN_RESOURCES);

        Role::firstOrCreate(['name' => 'Admin', 'guard_name' => self::GUARD])
            ->syncPermissions([...$adminPermissions]);

    }

    /**
     * @param  list<string>  $resources
     * @return list<string>
     */
    private function createPermissions(array $resources): array
    {
        $names = [];

        foreach ($resources as $resource) {
            foreach (self::ACTIONS as $action) {
                $names[] = Permission::firstOrCreate([
                    'name'       => "{$resource}-{$action}",
                    'guard_name' => self::GUARD,
                ])->name;
            }
        }

        return $names;
    }
}
