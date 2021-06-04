<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class IndonesiaProvincesSeeder extends Seeder
{
    /**
     * Run the database seeds.
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
            [
                'name' => 'Aceh (NAD)',
                'administration_code' => '11',
            ],
            [
                'name' => 'Bali',
                'administration_code' => '51',
            ],
            [
                'name' => 'Banten',
                'administration_code' => '36',
            ],
            [
                'name' => 'Bengkulu',
                'administration_code' => '17',
            ],
            [
                'name' => 'DI Yogyakarta',
                'administration_code' => '34',
            ],
            [
                'name' => 'DKI Jakarta',
                'administration_code' => '31',
            ],
            [
                'name' => 'Gorontalo',
                'administration_code' => '75',
            ],
            [
                'name' => 'Jambi',
                'administration_code' => '15',
            ],
            [
                'name' => 'Jawa Barat',
                'administration_code' => '32',
            ],
            [
                'name' => 'Jawa Tengah',
                'administration_code' => '33',
            ],
            [
                'name' => 'Jawa Timur',
                'administration_code' => '35',
            ],
            [
                'name' => 'Kalimantan Barat',
                'administration_code' => '61',
            ],
            [
                'name' => 'Kalimantan Selatan',
                'administration_code' => '63',
            ],
            [
                'name' => 'Kalimantan Tengah',
                'administration_code' => '62',
            ],
            [
                'name' => 'Kalimantan Timur',
                'administration_code' => '64',
            ],
            [
                'name' => 'Kalimantan Utara',
                'administration_code' => '65',
            ],
            [
                'name' => 'Kepulauan Bangka Belitung',
                'administration_code' => '19',
            ],
            [
                'name' => 'Kepulauan Riau',
                'administration_code' => '21',
            ],
            [
                'name' => 'Lampung',
                'administration_code' => '18',
            ],
            [
                'name' => 'Maluku',
                'administration_code' => '81',
            ],
            [
                'name' => 'Maluku Utara',
                'administration_code' => '82',
            ],
            [
                'name' => 'Nusa Tenggara Barat (NTB)',
                'administration_code' => '52',
            ],
            [
                'name' => 'Nusa Tenggara Timur (NTT)',
                'administration_code' => '53',
            ],
            [
                'name' => 'Papua',
                'administration_code' => '91',
            ],
            [
                'name' => 'Papua Barat',
                'administration_code' => '92',
            ],
            [
                'name' => 'Riau',
                'administration_code' => '14',
            ],
            [
                'name' => 'Sulawesi Barat',
                'administration_code' => '76',
            ],
            [
                'name' => 'Sulawesi Selatan',
                'administration_code' => '73',
            ],
            [
                'name' => 'Sulawesi Tengah',
                'administration_code' => '72',
            ],
            [
                'name' => 'Sulawesi Tenggara',
                'administration_code' => '74',
            ],
            [
                'name' => 'Sulawesi Utara',
                'administration_code' => '71',
            ],
            [
                'name' => 'Sumatera Barat',
                'administration_code' => '13',
            ],
            [
                'name' => 'Sumatera Selatan',
                'administration_code' => '16',
            ],
            [
                'name' => 'Sumatera Utara',
                'administration_code' => '12',
            ],
        ];

        foreach($datas as $data)
        {
            $uuid = (string) Str::uuid();
            $slug = create_slug('provinces', $data['name']);
            $get_indonesia_datas = DB::table('countries')
                ->where('slug', 'indonesia')
                ->first();

            DB::table('provinces')->insert([
                'country_id' => $get_indonesia_datas->id,
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
