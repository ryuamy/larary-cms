<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class NewsTagsSeeder extends Seeder
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
                'name' => 'Food',
                'slug' => 'food',
                'type' => 1,
                'status' => 1,
            ],
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'Drink',
                'slug' => 'drink',
                'type' => 1,
                'status' => 1,
            ],
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'Snack',
                'slug' => 'snack',
                'type' => 1,
                'status' => 1,
            ],
        ];

        foreach($datas as $data)
        {
            DB::table('tags')->insert([
                'uuid' => $data['uuid'],
                'name' => $data['name'],
                'slug' => $data['slug'],
                'type' => $data['type'],
                'status' => $data['status'],
                'created_by' => 1,
                'updated_by' => 1,
            ]);
        }
    }
}
