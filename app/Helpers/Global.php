<?php

/** old fashion */

/**
 * Old debug
 * 
 * @param array $array
 * 
 * @return boolean $exist_flag
 * 
 * @author Amy <laksmise@gmail.com>
 */
if(!function_exists('pre')) {
    function pre($array, $exist_flag = true) {
        echo '<pre>';
        print_r($array);
        echo '</pre>';
        if($exist_flag === true) {
            exit;
        }
    }
}

if(!function_exists('customTanggal')) {
    function customTanggal($date,$date_format) {
        return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format($date_format);    
    }
}

if(!function_exists('current_uri')) {
    function current_uri() {
        $currentURIPath = url()->current();
        $paths = explode('/', $currentURIPath);
        // $paths_total = count($paths);
        $_SESSION['current_lang'] = ($paths[0] !== '') ? $paths[0] : 'en';
        return $paths;
    }
}

if(!function_exists('admin_uri')) {
    function admin_uri() {
        $admin_url = env('APP_ADMIN_URL');
        return ($admin_url != null) ? $admin_url : env('APP_URL').'/admin/';
    }
}

if(!function_exists('base_css')) {
    function base_css() {
        return asset('/css').'/';
    }
}

if(!function_exists('base_js')) {
    function base_js() {
        return asset('/js').'/';
    }
}

if(!function_exists('base_img')) {
    function base_img() {
        return asset('/images').'/';
    }
}

/**
 * Get site settings
 * 
 * @param string $meta_value   
 * @param string $separator    separator, default is "|"
 * 
 * @return string
 * 
 * @author Amy <laksmise@gmail.com>
 * 
 */
if(!function_exists('get_site_settings')) {
    function get_site_settings($meta_key, $separator='|') {
        new \Illuminate\Support\Facades\DB;
        $select = DB::table('settings')
            ->where('status', 1)
            ->where('meta_key', $meta_key)
            ->orderBy('id', 'desc')
            ->first();
        $meta_value = $select->meta_value;
        return ($meta_key == 'title') ? ' '.$separator.' '.$meta_value : $meta_value;
    }
}

/**
 * Check is current browser is mobile device or desktop
 */
if(!function_exists('is_mobile')) {
    function is_mobile() {
        $detect = new \Detection\MobileDetect();
        if (!$detect->isMobile()) {
            return false;
        }
        return true;
    }
}

/**
 * custom pagination
 * 
 * param reference example
 * $param = array(
 * 		'base'          => 'user',
 * 		'page'          => $page,
 * 		'pages'         => $pages,
 * 		'key'           => 'page',
 * 		'next_text'		=> 'Next',
 * 		'prev_text'		=> 'Prev',
 * 		'first_text'	=> 'First',
 * 		'last_text'		=> 'Last',
 * 		'show_dots'     => true
 * );
 * 
 * param detail:
 * base         : (string - mandatory)	current page
 * page         : (integer - mandatory)	current page
 * pages        : (integer - mandatory)	total amount of pages
 * key          : (string - optional)   parameters name, default value 'page'
 * next_text	: (string - optional)   default value is 'Next'
 * prev_text	: (string - optional)   default value is 'Prev'
 * first_text	: (string - optional)   default value is 'First'
 * last_text	: (string - optional)   default value is 'Last'
 * show_dots    : (boolean - optional)  default value false
 *
 * @param array $params
 * @param string $adminpage
 * 
 * @return string $html
 * 
 * @author Amy <laksmise@gmail.com>
 * 
 */
if(!function_exists('custom_pagination')) {
    function custom_pagination($params, $adminpage='') {
        if(!empty($adminpage)) {

        }

        $key = (isset($params['key'])) ? $params['key'] : 'page';
        $next_text = (isset($params['next_text'])) ? $params['next_text'] : 'Next';
        $prev_text = (isset($params['prev_text'])) ? $params['prev_text'] : 'Prev';
        $first_text = (isset($params['first_text'])) ? $params['first_text'] : 'First';
        $last_text = (isset($params['last_text'])) ? $params['last_text'] : 'Last';

        $page = $params['page'];
        $pages = $params['pages'];
        $base = $params['base'];

        $prevs = array();
        for ($p=1; $p<=4; $p++) {
            $prevs[] = $page-$p;
        }
        sort($prevs);

        $nexts = array();
        for ($n=1; $n<=2; $n++) {
            $nexts[] = $page+$n;
        }
        sort($nexts);

        $html = '';

        if($pages>5 && $page!=1) {
            $html .= '<a class="first" href="'.$base.$key.'=1">'.$first_text.'</a> ';
        }

        if($page!=1) {
            $html .= '<a class="prev" href="'.$base.$key.'='.$prevs[3].'">'.$prev_text.'</a> ';
        }

        if($pages>5) {
            if($page<5) {
                for ($i=1; $i<=5 ; $i++) {
                    $active = ($page==$i) ? 'class="active"':'';
                    $html .= '<a href="'.$base.$key.'='.$i.'" '. $active.'>'. $i.'</a> ';
                }
                if(isset($params['show_dots']) && $params['show_dots'] === TRUE) {
                    $html .= '<span>...</span> ';
                }
            } else {
                if(isset($params['show_dots']) && $params['show_dots'] === TRUE) {
                    if($page!=1 || $page==$pages) {
                        $html .= '<span>...</span> ';
                    }
                }
                if($page!=$pages) {
                    unset($prevs[0]);
                    unset($prevs[1]);
                }
                foreach($prevs as $prev) {
                    if($page!=1 || $page==$pages) {
                        $html .= '<a href="'.$base.$key.'='.$prev.'">'.$prev.'</a> ';
                    }
                }
                $html .= '<a href="'.$base.$key.'='.$page.'" class="active">'.$page.'</a> ';
                if($page!=$pages) {
                    foreach($nexts as $next) {
                        if($next<=$pages) {
                            $html .= '<a href="'.$base.$key.'='.$next.'">'.$next.'</a> ';
                        }
                    }
                }
                if(isset($params['show_dots']) && $params['show_dots'] === TRUE) {
                    if($page!=$pages) {
                        $html .= '<span>...</span> ';
                    }
                }
            }
        } else {
            for ($i=1; $i<=$pages ; $i++) {
                $active = ($page==$i) ? 'class="active"':'';
                $html .= '<a href="'.$base.$key.'='. $i.'" '. $active.'>'. $i.'</a> ';
            }
        }

        if($page!=$pages && $nexts[0]<=$pages) {
            $html .= '<a class="next" href="'.$base.$key.'='. $nexts[0].'">'.$next_text.'</a> ';
        }
        if($pages>5 && $page!=$pages && $nexts[0]<=$pages) {
            $html .= '<a class="last" href="'.$base.$key.'='. $pages.'">'.$last_text.'</a> ';
        }

        if(isset($params['show_goto']) && $params['show_goto'] === TRUE) {
            //coming soon~
        }

        return $html;
    }
}

/**
 * Global limit for custom pagination
 * 
 * @return integer $limit
 * 
 * @author Amy <laksmise@gmail.com>
 */
if(!function_exists('custom_pagination_limit')) {
    function custom_pagination_limit() {
        $limit = (isset($_GET['limit'])) ? $_GET['limit'] : get_site_settings('admin_pagination_limit') ;
        return intval($limit);
    }
}

/**
 * Pagination number of showing to and showing from
 * 
 * @return array $rtn
 * 
 * @author Amy <laksmise@gmail.com>
 */
if(!function_exists('custom_pagination_prep')) {
    function custom_pagination_prep($total, $current_page) {
        $limit = custom_pagination_limit();
        $pages = ceil($total/$limit);
        $page = $current_page;

        $showing_from = 1;
        $showing_to = $limit;
        if($total < $limit) {
            $showing_to = $total;
        }
        if($current_page > 1) {
            $showing_from = $showing_to*($current_page-1)+1;
            $showing_to = $showing_to*$current_page;
        }
        //kalau udah halaman terakhir, showing_to = total
        if($pages == $current_page) {
            $showing_to = $total;
        }

        $rtn = [
            'pages'         => $pages,
            'page'          => $page,
            'showing_to'    => $showing_to,
            'showing_from'  => $showing_from
        ];

        return $rtn;
    }
}

/**
 * Pagination global sort link
 * 
 * @return string $link
 * 
 * @author Amy <laksmise@gmail.com>
 */
if(!function_exists('custom_sort_link')) {
    function custom_sort_link($menu, $params, $is_admin_page=true) {
        $link = ($is_admin_page === true) ? url(admin_uri().$menu.'?') : url('/'.$menu.'?');

        if(isset($params['limit'])) {
            $link =  $link.'limit='.$params['limit'].'&';
        }

        if(
        (isset($params['action']) && isset($params['page'])) || 
        (isset($params['action']) && !isset($params['page']))
        ) {
            if(isset($params['order']) && isset($params['sort'])) {
                unset($params['order']);
                unset($params['sort']);
            }
            foreach($params as $key_par => $par) {
                $link .= $key_par.'='.$par.'&';
            }
        } elseif(!isset($params['action']) && isset($params['page'])) {
            $link .= 'page='.$params['page'].'&';
        }

        return $link;
    }
}

/**
 * Pagination global link
 * 
 * @return string $link
 * 
 * @author Amy <laksmise@gmail.com>
 */
if(!function_exists('custom_pagination_link')) {
    function custom_pagination_link($menu, $params, $is_admin_page=true) {
        $link = ($is_admin_page === true) ? url(admin_uri().$menu.'?') : url('/'.$menu.'?');

        if(isset($params['limit'])) {
            $link =  $link.'limit='.$params['limit'].'&';
        }

        if(
        (isset($params['action']) && isset($params['order'])) || 
        (isset($params['action']) && !isset($params['order']))
        ) {
            foreach($params as $key_par => $par) {
                $link .= $key_par.'='.$par.'&';
            }
        } elseif(!isset($params['action']) && isset($params['order'])) {
            $link .= 'order='.$params['order'].'&';
            $link .= 'sort='.$params['sort'].'&';
        }

        return $link;
    }
}

/**
 * Pagination number of showing to and showing from
 * 
 * @return array $rtn
 * 
 * @author Amy <laksmise@gmail.com>
 */
if(!function_exists('custom_pagination_prep')) {
    function custom_pagination_prep($total, $current_page) {
        $limit = custom_pagination_limit();
        $pages = ceil($total/$limit);
        $page = $current_page;

        $showing_from = 1;
        $showing_to = $limit;
        if($total < $limit) {
            $showing_to = $total;
        }
        if($current_page > 1) {
            $showing_from = $showing_to*($current_page-1)+1;
            $showing_to = $showing_to*$current_page;
        }
        //kalau udah halaman terakhir, showing_to = total
        if($pages == $current_page) {
            $showing_to = $total;
        }

        $rtn = [
            'pages'         => $pages,
            'page'          => $page,
            'showing_to'    => $showing_to,
            'showing_from'  => $showing_from
        ];

        return $rtn;
    }
}

/**
 * Admin table header
 *
 * @param array $array
 * 
 * @return array $table_head
 * 
 * @author Amy <laksmise@gmail.com>
 */
if(!function_exists('admin_table_head')) {
    function admin_table_head($array) {
        $table_head = [];

        foreach($array['head'] as $value) {
            $table_head[$value] = array();
            $name_order = ( (isset($_GET['order']) && $_GET['order'] === $value) && (isset($_GET['sort']) && $_GET['sort'] === 'asc') ) ? 'desc' : 'asc';
            $name_class = ( (isset($_GET['order']) && $_GET['order'] === $value) && isset($_GET['sort']) ) ? $_GET['sort'] : 'desc';

            if( in_array($value, $array['disabled_head']) ) {
                $table_head[$value]['order'] = '';
                $table_head[$value]['class'] = '';
            } else {
                $table_head[$value]['order'] = 'order='.$value.'&sort='.$name_order;
                $table_head[$value]['class'] = $name_class;
            }
        }

        return $table_head;
    }
}

/**
 * Month in bahasa Indonesia
 *
 * @param int $month
 * 
 * @return string
 * 
 * @author Amy <laksmise@gmail.com>
 */
if(!function_exists('month_idn')) {
    function month_idn($month) {
        $bulan = array (
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        );
        return $bulan[$month];
    }
}

/**
 * Day in bahasa Indonesia
 *
 * @param int $day
 * 
 * @return string
 * 
 * @author Amy <laksmise@gmail.com>
 */
if(!function_exists('day_idn')) {
    function day_idn($day) {
        $hari = array (
            0 => 'Minggu',
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu'
        );
        return $hari[$day];
    }
}

/**
 * Create organized upload image folder
 * 
 * @return string $path
 * 
 * @author Amy <laksmise@gmail.com>
 */
if(!function_exists('create_uploads_folder')) {
    function create_uploads_folder() {
        $year_folder = './uploads/'.date('Y');
        if (!file_exists($year_folder)) {
            mkdir($year_folder, 0777);
        }
        $month_folder = $year_folder.'/'.date('m');
        if (!file_exists($month_folder)) {
            mkdir($month_folder, 0777);
        }
        $path = 'uploads/'.date('Y').'/'.date('m');
        return $path;
    }
}

/**
 * Create log file
 * 
 * @param string $message
 * @param string $foldername
 * 
 * @return string
 * 
 * @author Amy <laksmise@gmail.com>
 */
if(!function_exists('create_log')) {
    function create_log($message, $foldername='default') {
        if(env('APP_CREATE_LOG_FILE') === true) {
            $foldername = './logs/'.$foldername;
            if (!file_exists($foldername)) {
                mkdir($foldername, 0777);
            }

            $year_folder = $foldername.'/'.date('Y');
            if (!file_exists($year_folder)) {
                mkdir($year_folder, 0777);
            }

            $month_folder = $year_folder.'/'.date('m');
            if (!file_exists($month_folder)) {
                mkdir($month_folder, 0777);
            }
            
            $path = str_replace('./', '', $month_folder); //'logs/'.$foldername.'/'.date('Y').'/'.date('m');

            $insert_content = '';
            $insert_content .= '['.date('Y-m-d h:i:s A').'] [client '.$_SERVER['REMOTE_ADDR'].']'.' '.$message."\n";

            $stCurLogFileName = $path . '/file_log.log';

            $fHandler = fopen($stCurLogFileName,'a+');
            fwrite($fHandler, $insert_content);
            fclose($fHandler);

            return 'log created';
        }

        return 'failed create log';
    }
}

/**
 * Get client ip address
 *
 * @return string $ipaddress
 * 
 * @author Amy <laksmise@gmail.com>
 */
if(!function_exists('get_client_ip')) {
    function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
}

/**
 * Get client ip address location information
 *
 * @return array $output
 * 
 * @author Amy <laksmise@gmail.com>
 */
if(!function_exists('get_client_ip_info')) {
    function get_client_ip_info($ip = '173.252.110.27', $purpose = 'location', $deep_detect = TRUE) {
        $output = NULL;
        if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
            $ip = $_SERVER['REMOTE_ADDR'];
            if ($deep_detect) {
                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
            }
        }
        $purpose    = str_replace(array('name', '\n', '\t', ' ', '-', '_'), NULL, strtolower(trim($purpose)));
        $support    = array('country', 'countrycode', 'state', 'region', 'city', 'location', 'address');
        $continents = array(
            'AF' => 'Africa',
            'AN' => 'Antarctica',
            'AS' => 'Asia',
            'EU' => 'Europe',
            'OC' => 'Australia (Oceania)',
            'NA' => 'North America',
            'SA' => 'South America'
        );
        if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
            $ipdat = @json_decode(file_get_contents('http://www.geoplugin.net/json.gp?ip='.$ip));
            if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
                switch ($purpose) {
                    case 'location':
                        $output = array(
                            'city'           => @$ipdat->geoplugin_city,
                            'state'          => @$ipdat->geoplugin_regionName,
                            'country'        => @$ipdat->geoplugin_countryName,
                            'country_code'   => @$ipdat->geoplugin_countryCode,
                            'continent'      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                            'continent_code' => @$ipdat->geoplugin_continentCode
                        );
                    break;
                    case 'address':
                        $address = array($ipdat->geoplugin_countryName);
                        if (@strlen($ipdat->geoplugin_regionName) >= 1)
                            $address[] = $ipdat->geoplugin_regionName;
                        if (@strlen($ipdat->geoplugin_city) >= 1)
                            $address[] = $ipdat->geoplugin_city;
                            $output = implode(', ', array_reverse($address));
                    break;
                    case 'city':
                        $output = @$ipdat->geoplugin_city;
                    break;
                    case 'state':
                        $output = @$ipdat->geoplugin_regionName;
                    break;
                    case 'region':
                        $output = @$ipdat->geoplugin_regionName;
                    break;
                    case 'country':
                        $output = @$ipdat->geoplugin_countryName;
                    break;
                    case 'countrycode':
                        $output = @$ipdat->geoplugin_countryCode;
                    break;
                }
            }
        }
        return $output;
    }
}

/**
 * Get client locale
 *
 * @return array
 * 
 * @author Amy <laksmise@gmail.com>
 */
if(!function_exists('get_client_locale')) {
    function get_client_locale() {
        $ip = get_client_ip();
        if($ip == 'UNKNOWN') {
            $ip = '173.252.110.27';
        }
        return get_client_ip_info($ip, 'Country Code');
    }
}

/**
 * Gives a nicely-formatted list of timezone strings.
 * copyright: Wordpress
 *
 * @since 2.9.0
 * @since 4.7.0 Added the `$locale` parameter.
 *
 * @staticvar bool $mo_loaded
 * @staticvar string $locale_loaded
 *
 * @param string $selected_zone Selected timezone.
 * @param string $locale        Optional. Locale to load the timezones in. Default current site locale.
 * 
 * @return string
 */
if(!function_exists('timezone_choice')) {
    function timezone_choice($selected_zone, $locale = null) {
        static $mo_loaded = false, $locale_loaded = null;

        $continents = array( 'Africa', 'America', 'Antarctica', 'Arctic', 'Asia', 'Atlantic', 'Australia', 'Europe', 'Indian', 'Pacific' );

        $zonen = array();
        foreach ( timezone_identifiers_list() as $zone ) {
            $zone = explode( '/', $zone );
            if ( ! in_array( $zone[0], $continents ) ) {
                continue;
            }

            $exists    = array(
                0 => ( isset( $zone[0] ) && $zone[0] ),
                1 => ( isset( $zone[1] ) && $zone[1] ),
                2 => ( isset( $zone[2] ) && $zone[2] ),
            );
            $exists[3] = ( $exists[0] && 'Etc' !== $zone[0] );
            $exists[4] = ( $exists[1] && $exists[3] );
            $exists[5] = ( $exists[2] && $exists[3] );

            $zonen[] = array(
                'continent'   => ( $exists[0] ? $zone[0] : '' ),
                'city'        => ( $exists[1] ? $zone[1] : '' ),
                'subcity'     => ( $exists[2] ? $zone[2] : '' ),
            );
        }

        $structure = array();

        if ( empty( $selected_zone ) ) {
            $structure[] = '<option selected="selected" value="">'.__( 'Select a city' ).'</option>';
        }

        foreach ( $zonen as $key => $zone ) {
            // Build value in an array to join later.
            $value = array( $zone['continent'] );

            if ( empty( $zone['city'] ) ) {
                // It's at the continent level (generally won't happen).
                $display = $zone['continent'];
            } else {
                // It's inside a continent group.

                // Continent optgroup.
                if ( ! isset( $zonen[ $key - 1 ] ) || $zonen[ $key - 1 ]['continent'] !== $zone['continent'] ) {
                    $label       = $zone['continent'];
                    $structure[] = '<optgroup label="'.$label.'">';
                }

                // Add the city to the value.
                $value[] = $zone['city'];

                $display = $zone['city'];
                if ( ! empty( $zone['subcity'] ) ) {
                    // Add the subcity to the value.
                    $value[]  = $zone['subcity'];
                    $display .= ' - '.$zone['subcity'];
                }
            }

            // Build the value.
            $value    = join( '/', $value );
            $selected = '';
            if ( $value === $selected_zone ) {
                $selected = 'selected="selected" ';
            }

            $display = str_replace('_', ' ', $display);

            $structure[] = '<option '.$selected.'value="'.$value.'">'.$display.'</option>';

            // Close continent optgroup.
            if ( ! empty( $zone['city'] ) && ( ! isset( $zonen[ $key + 1 ] ) || ( isset( $zonen[ $key + 1 ] ) && $zonen[ $key + 1 ]['continent'] !== $zone['continent'] ) ) ) {
                $structure[] = '</optgroup>';
            }
        }

        // Do UTC.
        $structure[] = '<optgroup label="UTC">';
        $selected    = '';
        if ( 'UTC' === $selected_zone ) {
            $selected = 'selected="selected" ';
        }
        $structure[] = '<option '.$selected.'value="UTC">UTC</option>';
        $structure[] = '</optgroup>';

        // Do manual UTC offsets.
        $structure[]  = '<optgroup label="Manual Offsets">';
        $offset_range = array(
            -12,
            -11.5,
            -11,
            -10.5,
            -10,
            -9.5,
            -9,
            -8.5,
            -8,
            -7.5,
            -7,
            -6.5,
            -6,
            -5.5,
            -5,
            -4.5,
            -4,
            -3.5,
            -3,
            -2.5,
            -2,
            -1.5,
            -1,
            -0.5,
            0,
            0.5,
            1,
            1.5,
            2,
            2.5,
            3,
            3.5,
            4,
            4.5,
            5,
            5.5,
            5.75,
            6,
            6.5,
            7,
            7.5,
            8,
            8.5,
            8.75,
            9,
            9.5,
            10,
            10.5,
            11,
            11.5,
            12,
            12.75,
            13,
            13.75,
            14,
        );

        foreach ( $offset_range as $offset ) {
            if ( 0 <= $offset ) {
                $offset_name = '+'.$offset;
            } else {
                $offset_name = (string) $offset;
            }

            $offset_value = $offset_name;
            $offset_name  = str_replace( array( '.25', '.5', '.75' ), array( ':15', ':30', ':45' ), $offset_name );
            $offset_name  = 'UTC'.$offset_name;
            $offset_value = 'UTC'.$offset_value;

            $selected     = '';
            if ( $offset_value === $selected_zone ) {
                $selected = 'selected="selected" ';
            }
            $structure[] = '<option '.$selected.'value="'.$offset_value.'">'.$offset_name.'</option>';
        }
        $structure[] = '</optgroup>';

        return join( '\n', $structure );
    }
}

/**
 * Create slug
 * 
 * @param string $table
 * 
 * @return string $title
 * @return string $separator
 * 
 * @author Amy <laksmise@gmail.com>
 */
if(!function_exists('create_slug')) {
    function create_slug($table, $title, $separator = '-') {
        new \Illuminate\Support\Facades\DB;

        $slug = strtolower(str_replace(' ', $separator, $title));

        $check = DB::table($table)
            ->where('slug', 'like', '%'.$slug.'%')
            ->get();
        
        if(count($check) > 0) {
            $total = count($check) + 1;
            $slug = $slug.$separator.$total;
        }

        return $slug;
    }
}

/**
 * Global adsmedia / raja sms api
 * 
 * param reference example
 * $param = array(
 * 		'service'   => 'SMS_OTP',
 * 		'number'    => '0812345xxxxx,
 * 		'message'   => 'hello world'
 * );
 * 
 * param detail:
 * service  : (string - mandatory)	options are "MISSCALL_OTP", "SMS_OTP", "SMS_MASKING", "WA", "CHECK_BALANCE"
 * number   : (string - optional)	phone number. accept numberic only and indonesia number only
 * message  : (string - optional)	alpha numberic only and must be less than 890 character
 * 
 * @param array $params
 * 
 * @return array $return
 * 
 * @author Amy <laksmise@gmail.com>
 */
if(!function_exists('adsmedia_api')) {
    function adsmedia_api($params) {
        // ob_start();

        // if(!$params['service']) {
        //     $return = [
        //         'code'      => 400,
        //         'response'  => 'failed',
        //         'message'   => 'Please tell us service name',
        //         'datas'     => []
        //     ];

        //     return $return;
        // }

        // if(preg_match('/[^A-Z_]/i', $params['service'])) {
        //     $return = [
        //         'code'      => 400,
        //         'response'  => 'failed',
        //         'message'   => 'Invalid service name',
        //         'datas'     => []
        //     ];

        //     return $return;
        // }
        
        // $apikey         = env('RAJASMS_KEY');
        // $apiusername    = env('RAJASMS_USERNAME');
        // $apiurl         = env('RAJASMS_URL');
        // $callbackurl    = env('RAJASMS_CALLBACK');
        // $endpointurl    = $apiurl;
        // $senddata       = array();
 
        // if($params['service'] === 'SMS_OTP') {
        //     $endpointurl = $endpointurl.'api_sms_otp_send_json.php';

        //     $senddata = array(
        //         'apikey'        => $apikey,  
        //         'callbackurl'   => $callbackurl, 
        //         'datapackets'    => array()
        //     );
            
        //     $number = preg_replace( '/[^0-9]/i', '', $params['number'] );

        //     $message = preg_replace( '/[\W]/', '', $params['message'] );
        //     $count_message = strlen($message);
        //     if($count_message > 145) {
        //         $message = substr($message, 0, 145).'(cropped)';
        //     }

        //     array_push($senddata['datapackets'], array(
        //         'number'    => $number,
        //         'message'   => $message
        //     ));
        // }
 
        // if($params['service'] === 'SMS_MASKING') {
        //     $number = preg_replace( '/[^0-9]/i', '', $params['number'] );

        //     $message = preg_replace( '/[\W]/', '', $params['message'] );
        //     $count_message = strlen($message);
        //     if($count_message > 870) {
        //         $message = substr($message, 0, 900).'(cropped)';
        //     }

        //     $endpointurl = $endpointurl.'smsmasking.php?username='.$apikey.'&key='.$apikey.'&number='.$number.'&message='.$message;
        // }
 
        // if($params['service'] === 'MISSCALL_OTP') {
        //     $endpointurl = $endpointurl.'api_misscall_otp_send_json.php';

        //     $senddata = array(
        //         'apikey' => $apikey
        //     );
        // }
 
        // if($params['service'] === 'WA') {
        //     $endpointurl = $endpointurl.'api_whatsapp_send_json.php';

        //     $senddata = array(
        //         'apikey' => $apikey
        //     );
        // }
 
        // if($params['service'] === 'CHECK_BALANCE') {
        //     $endpointurl = $endpointurl.'api_sms_otp_balance_json.php';

        //     $senddata = array(
        //         'apikey' => $apikey
        //     );
        // }
 
        // $data = json_encode($senddata);
        // $curlHandle = curl_init($endpointurl);

        // curl_setopt($curlHandle, CURLOPT_CUSTOMREQUEST, 'POST');
        // curl_setopt($curlHandle, CURLOPT_POSTFIELDS, $data);
        // curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($curlHandle, CURLOPT_HTTPHEADER, array(
        //     'Content-Type: application/json',
        //     'Content-Length: '.strlen($data))
        // );
        // curl_setopt($curlHandle, CURLOPT_TIMEOUT, 30);
        // curl_setopt($curlHandle, CURLOPT_CONNECTTIMEOUT, 30);
        // $respon = curl_exec($curlHandle);
        // curl_close($curlHandle);

        // $response = json_decode($respon);
        // echo '<pre>';
        // print_r($response->sending_respon[0]);
        // echo '</pre>';
        // exit;
        
        // $return = [
        //     'code'      => 200,
        //     'response'  => 'success',
        //     'message'   => '',
        //     'datas'     => json_decode($respon)
        // ];

        // return $return;
    }
}

?>