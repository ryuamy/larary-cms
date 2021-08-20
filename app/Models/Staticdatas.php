<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staticdatas extends Model
{
    use HasFactory;

    //because we dont have this table, and not sure should I create one?
    public static function education() {
        $list = [];
        $list[1] = 'Tidak Sekolah';
        $list[2] = 'Sekolah Dasar / Sederajat';
        $list[3] = 'Sekolah Menengah Pertama / Sederajat';
        $list[4] = 'Sekolah Lanjut Tingkat Atas / Sederajat';
        $list[5] = 'Akademi / Diploma';
        $list[6] = 'Diploma / Strata I';
        $list[7] = 'Strata II';
        $list[8] = 'Strata III';

        return $list;
    }

    //because we dont have this table, and not sure should I create one?
    public static function citizenship() {
        $list = [];
        $list[1] = 'WNI';
        $list[2] = 'WNA';

        return $list;
    }

    //because we dont have this table, and not sure should I create one?
    public static function gender() {
        $list = [];
        $list[1] = 'Laki-Laki';
        $list[2] = 'Perempuan';

        return $list;
    }

    //because we dont have this table, and not sure should I create one?
    public static function default_status() {
        $list = [];
        $list[0] = 'Inactive';
        $list[1] = 'Active';

        return $list;
    }

    //because we dont have this table, and not sure should I create one?
    public static function category_tag_type() {
        $list = [];
        $list[0] = '-';
        $list[1] = 'News';

        return $list;
    }

    //because we dont have this table, and not sure should I create one?
    public static function idn_driver_license() {
        $list = [];
        $list[0] = '-';
        $list[1] = 'A';
        $list[2] = 'A UMUM';
        $list[3] = 'BI';
        $list[4] = 'BII';
        $list[5] = 'BI UMUM';
        $list[6] = 'BII UMUM';
        $list[7] = 'C';
        $list[8] = 'CI';
        $list[9] = 'CII';
        $list[10] = 'D';
        $list[11] = 'DI';

        return $list;
    }

    //because we dont have this table, and not sure should I create one?
    public static function date_format() {
        $list = [];
        $list[1] = 'F j, Y';
        $list[2] = 'Y-m-d';
        $list[3] = 'm/d/Y';
        $list[4] = 'd/m/Y';

        return $list;
    }

    //because we dont have this table, and not sure should I create one?
    public static function time_format() {
        $list = [];
        $list[1] = 'g:i a';
        $list[2] = 'g:i A';
        $list[3] = 'H:i';

        return $list;
    }
}
