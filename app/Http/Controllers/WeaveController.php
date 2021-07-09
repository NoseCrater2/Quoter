<?php

namespace App\Http\Controllers;

use App\Weave;
use Illuminate\Http\Request;
use App\Http\Resources\WeaveIndexResource;
use App\Http\Resources\SunblindIndexResource;

class WeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $weaves = Weave::has('subweaves')->with('subweaves:slug,name')->get();
        return response(['data'=> $weaves],200);
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
     * @param  \App\Weave  $weave
     * @return \Illuminate\Http\Response
     */
    public function show(Weave $weave)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Weave  $weave
     * @return \Illuminate\Http\Response
     */
    public function edit(Weave $weave)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Weave  $weave
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Weave $weave)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Weave  $weave
     * @return \Illuminate\Http\Response
     */
    public function destroy(Weave $weave)
    {
        //
    }

    public function getSunblinds(Weave $weave)
    {
        return SunblindIndexResource::collection(
            $weave->sunblinds
        );
    }
}
