<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

// Make sure to add Modules manually every time you create new admin page
class ModulesSeeder extends Seeder
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
                'name' => 'Admins',
                'slug' => 'admins',
            ],
            [
                'name' => 'Admin Roles',
                'slug' => 'admin_roles',
            ],
            [
                'name' => 'Cities',
                'slug' => 'cities',
            ],
            [
                'name' => 'Countries',
                'slug' => 'countries',
            ],
            [
                'name' => 'Galleries',
                'slug' => 'galleries',
            ],
            [
                'name' => 'Modules',
                'slug' => 'modules',
            ],
            [
                'name' => 'News',
                'slug' => 'news',
            ],
            [
                'name' => 'News Categories',
                'slug' => 'news_categories',
            ],
            [
                'name' => 'News Tags',
                'slug' => 'news_tags',
            ],
            [
                'name' => 'Pages',
                'slug' => 'pages',
            ],
            [
                'name' => 'Provinces',
                'slug' => 'provinces',
            ],
            [
                'name' => 'General Settings',
                'slug' => 'general_settings',
            ],
            [
                'name' => 'SEO Website Settings',
                'slug' => 'seo_website_settings',
            ],
            [
                'name' => 'File Upload Settings',
                'slug' => 'file_upload_settings',
            ],
            [
                'name' => 'Users',
                'slug' => 'users',
            ],
        ];

        foreach($datas as $data)
        {
            DB::table('modules')->insert([
                'name' => $data['name'],
                'slug' => $data['slug'],
                'status' => 1,
            ]);
        }
    }
}
