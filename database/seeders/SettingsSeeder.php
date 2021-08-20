<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
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
                'meta_key' => 'title',
                'meta_value' => 'CMS',
                'status' => '1',
            ],
            [
                'meta_key' => 'tagline',
                'meta_value' => 'CMS',
                'status' => '1',
            ],
            [
                'meta_key' => 'description',
                'meta_value' => 'CMS',
                'status' => '1',
            ],
            [
                'meta_key' => 'focus_keyphrase',
                'meta_value' => '',
                'status' => '1',
            ],
            [
                'meta_key' => 'timezone',
                'meta_value' => 'UTC+7',
                'status' => '1',
            ],
            [
                'meta_key' => 'date_format',
                'meta_value' => 'Y-m-d',
                'status' => '1',
            ],
            [
                'meta_key' => 'time_format',
                'meta_value' => 'g:i A',
                'status' => '1',
            ],
            [
                'meta_key' => 'admin_pagination_limit',
                'meta_value' => '20',
                'status' => '1',
            ],
            [
                'meta_key' => 'language',
                'meta_value' => 'id_ID',
                'status' => '1',
            ],
            [
                'meta_key' => 'start_of_week',
                'meta_value' => '1',
                'status' => '1',
            ],
        ];

        foreach($datas as $data)
        {
            DB::table('settings')->insert([
                'meta_key' => $data['meta_key'],
                'meta_value' => $data['meta_value'],
                'status' => $data['status'],
                'created_by' => 1,
                'updated_by' => 1,
            ]);
        }
    }
}
