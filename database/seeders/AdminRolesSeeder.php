<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class AdminRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'Super Admin',
                'slug' => 'super_admin',
                'status' => '1',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'Admin',
                'slug' => 'admin',
                'status' => '1',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'Editor',
                'slug' => 'editor',
                'status' => '1',
            ],
        ];

        foreach($datas as $data)
        {
            DB::table('admin_roles')->insert([
                'uuid' => $data['uuid'],
                'name' => $data['name'],
                'slug' => $data['slug'],
                'status' => $data['status'],
                'created_by' => 1,
                'updated_by' => 1,
            ]);
        }
    }
}
