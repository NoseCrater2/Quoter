<?php

namespace App\Http\Controllers;

use App\Http\Resources\SunblindShowResource;
use App\Sunblind;
use Illuminate\Http\Request;
use App\Imports\SunblindsImport;
use App\Http\Resources\SunblindIndexResource;


class SunblindController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Sunblind  $sunblind
     * @return \Illuminate\Http\Response
     */
    public function show(Sunblind $sunblind)
    {
        return new SunblindShowResource(Sunblind::findOrFail($sunblind->id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sunblind  $sunblind
     * @return \Illuminate\Http\Response
     */
    public function edit(Sunblind $sunblind)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sunblind  $sunblind
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sunblind $sunblind)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sunblind  $sunblind
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sunblind $sunblind)
    {
        //
    }

    public function importSunblinds(Request $request)
    {
        $file = $request->file('file');
        $import = new SunblindsImport;

        $import->import($file);
        //Excel::import(new VariantsImport, );
        if($import->failures()->isNotEmpty()){
           return response($import->failures());
        }
    }

    public function getRelatedBlinds(Sunblind $sunblind)
    {
       return SunblindIndexResource::collection(
            Sunblind::orderByRaw('rand()')->where('weave_id', '=', $sunblind->weave->id)->take(4)->get()
        );
    }
}
