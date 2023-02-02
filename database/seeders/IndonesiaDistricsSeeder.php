<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class IndonesiaDistricsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Kecamatan Indonesia
     * 
     * // NOTES :
     * Please make sure the global helper loaded
     *
     * source code: https://info.cabdindiksby.com/2019/05/26/kode-provinsi-dan-kota-indonesia/
     * source code administration: https://www.nomor.net/_kodepos.php?_i=kode-wilayah&asc=000&urut=1#Provinsi2
     *
     * @return void
     */
    public function run()
    {
        $datas = [

        ];

        foreach($datas as $data)
        {
            $uuid = (string) Str::uuid();
            $slug = create_slug('distric', $data['name']);
            $get_indonesia_datas = DB::table('cities')
                ->where('slug', 'indonesia')
                ->first();

            DB::table('distric')->insert([
                'country_id' => $get_indonesia_datas->id,
                'province_id' => $data['province_id'],
                'city_id' => $get_indonesia_datas->id,
                'uuid' => $uuid,
                'name' => $data['name'],
                'slug' => $slug,
                'administration_code' => $data['administration_code'],
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
            ]);
        }
    }
}
