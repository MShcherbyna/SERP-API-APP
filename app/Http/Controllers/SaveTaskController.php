<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use DataForSeo;

class SaveTaskController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function store(Request $request)
    {
        if ($request->token != config('dataforseo.se_token')) {
            Log::error("DataForSeo pingback error!");
            Log::error("The token does not match");
        }

        DataForSeo::saveTaskResult($request->task_id);
    }
}
