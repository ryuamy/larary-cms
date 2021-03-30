<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PagesSeeder extends Seeder
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
                'name' => 'Home',
                'slug' => 'home',
                'content' => '',
                'status' => '1',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'About Us',
                'slug' => 'about-us',
                'content' => '',
                'status' => '1',
            ],
            [
                'uuid' => (string) Str::uuid(),
                'name' => 'Contact Us',
                'slug' => 'contact-us',
                'content' => '',
                'status' => '1',
            ],
        ];

        foreach($datas as $data)
        {
            DB::table('pages')->insert([
                'uuid' => $data['uuid'],
                'name' => $data['name'],
                'slug' => $data['slug'],
                'content' => $data['content'],
                'status' => $data['status'],
                'created_by' => 1,
                'updated_by' => 1,
            ]);
        }
    }
}
