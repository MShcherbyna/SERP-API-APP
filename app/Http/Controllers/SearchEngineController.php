<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataForSeo;

class SearchEngineController extends Controller
{
    /**
     * Display a listing of the Search Engines.
     * @param string $code
     * @return \Illuminate\Http\Response
     */
    public function index($code = '')
    {
        if (empty($code)) {
            return false;
        }

        $searchEngines = DataForSeo::getSearchEngine($code);

        return response()->json($searchEngines['data'], $searchEngines['status']);
    }

}
