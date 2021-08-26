<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\Pages;

class SitemapController extends Controller
{

    public function __construct()
    {

    }

    /**
     * IMPORTANT: Sitemaps should be no larger than 10MB (10,485,760 bytes) and can contain a maximum of 50,000 URLs. These limits help to ensure that your web server does not get bogged down serving very large files. This means that if your site contains more than 50,000 URLs or your Sitemap is bigger than 10MB, you must create multiple Sitemap files and use a Sitemap index file. You should use a Sitemap index file even if you have a small site but plan on growing beyond 50,000 URLs or a file size of 10MB (which is something that will probably never happen to Laraget.com). A Sitemap index file can include up to 1,000 Sitemaps and must not exceed 10MB (10,485,760 bytes). You can also use gzip to compress your Sitemaps.
     */
    public function sitemap()
    {
        $datas = [];
        $datas['pages'] = Pages::where('deleted_at', NULL)->orderBy('updated_at', 'DESC')->get();
        // return view('admin.pages.index', $datas);
        return response()->view('application.sitemap', $datas)->header('Content-Type', 'text/xml');
    }

}
