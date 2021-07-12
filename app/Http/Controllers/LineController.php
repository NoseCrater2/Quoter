<?php

namespace App\Http\Controllers;

use App\Line;
use App\Type;
use Illuminate\Http\Request;
use App\Http\Resources\LineIndexResource;
use App\Http\Resources\VariantIndexResource;
use App\Http\Resources\WeaveIndexResource;

class LineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lines = Line::with('types:slug')->get();
        // return response(['data'=> $variants],200);
        return response(['data'=> $lines],200);
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
     * @param  \App\Line  $line
     * @return \Illuminate\Http\Response
     */
    public function show(Line $line)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Line  $line
     * @return \Illuminate\Http\Response
     */
    public function edit(Line $line)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Line  $line
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Line $line)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Line  $line
     * @return \Illuminate\Http\Response
     */
    public function destroy(Line $line)
    {
        //
    }

    public function getVariants(String $slug)
    {
        $line  = Line::where('slug', '=', $slug)->get();
        return VariantIndexResource::collection(
            $line[0]->variants->sortByDesc('name')
        );
    }

    public function getWeaves(String $slug)
    {
        $line  = Line::where('slug', '=', $slug)->first();
        return WeaveIndexResource::collection(
            $line->weaves
        );
    }

    public function getLinesByType(){}
}
