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
        $list[1] = "Tidak Sekolah";
        $list[2] = "Sekolah Dasar / Sederajat";
        $list[3] = "Sekolah Menengah Pertama / Sederajat";
        $list[4] = "Sekolah Lanjut Tingkat Atas / Sederajat";
        $list[5] = "Akademi / Diploma";
        $list[6] = "Diploma / Strata I";
        $list[7] = "Strata II";
        $list[8] = "Strata III";

        return $list;
    }

    //because we dont have this table, and not sure should I create one?
    public static function citizenship() {
        $list = [];
        $list[1] = "WNI";
        $list[2] = "WNA";

        return $list;
    }

    //because we dont have this table, and not sure should I create one?
    public static function gender() {
        $list = [];
        $list[1] = "Laki-Laki";
        $list[2] = "Perempuan";

        return $list;
    }

    //because we dont have this table, and not sure should I create one?
    public static function level() {
        $list = [];
        $list[1] = "Admin";
        $list[2] = "Stakeholder";
        $list[3] = "Masyarakat";

        return $list;
    }

    //because we dont have this table, and not sure should I create one?
    public static function default_status() {
        $list = [];
        $list[0] = "Inactive";
        $list[1] = "Active";
        $list[2] = "Deleted";

        return $list;
    }
}
