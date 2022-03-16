<?php

namespace App\Http\Controllers\Api\Countries;

use App\Http\Controllers\Controller;
use App\Models\Admins;
use App\Models\Adminrolemodules;
use App\Models\Countries;
use App\Models\Staticdatas;
use Illuminate\Support\Facades\Auth;

class CountriesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->table = 'countries';
        $this->base_url = env('APP_URL');
    }

    public function index()
    {
        $param_get = isset($_GET) ? $_GET : [];

        $datas_list = Countries::select(
                            'uuid',
                            'name',
                            'slug',
                            'iso_alpha_2_code',
                            'iso_alpha_3_code',
                            'un_code',
                            'phone_code',
                            'flag',
                            'capital_city',
                            'created_at',
                            'updated_at'
                        )
                        ->where('deleted_at', NULL);

        //*** Filter
        if(isset($_GET['action'])) {
            if(isset($_GET['name'])) {
                if( $_GET['condition'] === 'like' ) {
                    $datas_list = $datas_list->where('name', 'like', '%'.$_GET['name'].'%');
                }
                if( $_GET['condition'] === 'equal' ) {
                    $datas_list = $datas_list->where('name', $_GET['name']);
                }
            }
            if( $_GET['status'] !== 'all' ) {
                $datas_list = $datas_list->where('status', $_GET['status']);
            }
            if(isset($_GET['created_from']) && isset($_GET['created_to'])) {
                $datas_list = $datas_list
                    ->where('created_at', '>', date('Y-m-d', strtotime($_GET['created_from'])).' 00:00:00')
                    ->where('created_at', '<', date('Y-m-d', strtotime($_GET['created_to'])).' 23:59:59');
            }
        }
        //*** Filter

        //*** Sort
        $order = 'name';
        if(isset($param_get['order'])) {
            $order = $param_get['order'];
            if($param_get['order'] == 'created_date') {
                $order = 'created_at';
            } elseif($param_get['order'] == 'updated_date') {
                $order = 'updated_at';
            }
        }
        $sort = (isset($param_get['sort'])) ? strtoupper($param_get['sort']) : 'ASC';
        $datas_list = $datas_list->orderByRaw($order.' '.$sort);
        //*** Sort

        $datas['base_url'] = $this->base_url;
        
        if (empty($datas_list->get())) {
            return response()->json(
                    [
                        'code' => 404,
                        'message' => 'Can not get countries list. No datas found.',
                        'datas' => []
                    ], 404
                );
        }

        $datas['total'] = count($datas_list->get());

        $limit = custom_pagination_limit();
        $offset = (isset($param_get['page']) && $param_get['page'] > 1) ? ($param_get['page'] * $limit) - $limit : 0;
        $datas['list'] = $datas_list->offset($offset)->limit($limit)->get();

        return response()->json(
                [
                    'code' => 200,
                    'message' => 'Success get countries list',
                    'datas' => $datas
                ], 200
            );
    }
}
