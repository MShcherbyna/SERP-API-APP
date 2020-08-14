<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchDataRequest;
use DataForSeo;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = DataForSeo::getTaskList();

        return response()->json($result, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\SearchDataRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SearchDataRequest $request)
    {
        $result = DataForSeo::createTask($request->all());

        return response()->json($result['data'], $result['status']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id = '')
    {
        if ($id == '') return response()->json([], 404);

        $result = DataForSeo::getTaskResults($id);

        return response()->json($result, 200);
    }


}
