<?php

namespace App\Http\Controllers\Admin;

use App\Exports\TamuExport;
use App\Exports\TamuKunjunganExport;
use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    
    public function export_excel($table)
    {
        try {
            ob_end_clean();
            ob_start();

            if($table == 'tamu') {
                $file_name = 'Daftar Tamu.xlsx';
                return Excel::download(new TamuExport('xls', $_GET['bulk'], $_GET['date_from'], $_GET['date_to']), $file_name, null, [\Maatwebsite\Excel\Excel::XLSX]);
            }

            if($table == 'tamu_kunjungan') {
                $file_name = 'Daftar Kunjungan.xlsx';
                return Excel::download(new TamuKunjunganExport('xls', $_GET['bulk'], $_GET['date_from'], $_GET['date_to']), $file_name, null, [\Maatwebsite\Excel\Excel::XLSX]);
            }

            if($table == 'users') {
                $file_name = 'Daftar User.xlsx';
                return Excel::download(new UsersExport('xls', $_GET['bulk'], $_GET['date_from'], $_GET['date_to']), $file_name, null, [\Maatwebsite\Excel\Excel::XLSX]);
            }
        } catch (exception $e) {

        }
    }

    public function export_csv($table)
    {
        try {
            ob_end_clean();
            ob_start();

            if($table == 'tamu') {
                $file_name = 'Daftar Tamu.csv';
                return Excel::download(new TamuExport('csv', $_GET['bulk'], $_GET['date_from'], $_GET['date_to']), $file_name, null, [\Maatwebsite\Excel\Excel::CSV]);
            }
            
            if($table == 'tamu_kunjungan') {
                $file_name = 'Daftar Kunjungan.csv';
                return Excel::download(new TamuKunjunganExport('csv', $_GET['bulk'], $_GET['date_from'], $_GET['date_to']), $file_name, null, [\Maatwebsite\Excel\Excel::CSV]);
            }

            if($table == 'users') {
                $file_name = 'Daftar User.xlsx';
                return Excel::download(new UsersExport('xls', $_GET['bulk'], $_GET['date_from'], $_GET['date_to']), $file_name, null, [\Maatwebsite\Excel\Excel::XLSX]);
            }
        } catch (exception $e) {

        }
    }
}
