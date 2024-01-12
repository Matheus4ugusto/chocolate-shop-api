<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'ADMIN', 'CUSTOMER'
        ];

        foreach ($permissions as $permission) {
            $savedPermission = Permission::where('name', $permission)->first();
            if (!$savedPermission) {
                Permission::create([
                    'name' => $permission
                ]);
            }
        }
    }
}
