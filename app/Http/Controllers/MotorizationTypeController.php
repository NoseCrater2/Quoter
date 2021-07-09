<?php

namespace App\Http\Controllers;

use App\MotorizationType;
use Illuminate\Http\Request;
use App\Http\Resources\IndexMotorizationTypeResource;

class MotorizationTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return IndexMotorizationTypeResource::collection(
            MotorizationType::get()
        );   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MotorizationType  $motorizationType
     * @return \Illuminate\Http\Response
     */
    public function show(MotorizationType $motorizationType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MotorizationType  $motorizationType
     * @return \Illuminate\Http\Response
     */
    public function edit(MotorizationType $motorizationType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MotorizationType  $motorizationType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MotorizationType $motorizationType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MotorizationType  $motorizationType
     * @return \Illuminate\Http\Response
     */
    public function destroy(MotorizationType $motorizationType)
    {
        //
    }
}
