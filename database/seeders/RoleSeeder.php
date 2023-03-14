<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Schema::hasTable('roles')) {
            Role::firstOrCreate([
                'name' => 'Admin',
                'slug' => 'admin'
            ]);
            Role::firstOrCreate([
                'name' => 'Company',
                'slug' => 'company'
            ]);
        }
    }
}
