<?php

namespace App\Http\Controllers;

use App\Type;
use Illuminate\Http\Request;
use App\Http\Resources\TypeIndexResurce;
use App\Http\Resources\LineIndexResource;
use App\Http\Resources\VariantIndexResource;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = Type::withCount('lines as lines')->withCount('weaves as weaves')->get();
        // return TypeIndexResurce::collection(
        //     Type::get()
        // );
        return response(['data'=> $types],200);
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
     * @param  \App\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function show(Type $type)
    {
        return response($type, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function edit(Type $type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Type $type)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        //
    }

    public function getLines(String $slug)
    {
      $type = Type::where('slug','=', $slug)->get();
        return LineIndexResource::collection(
            $type[0]->lines
        );
    }

    public function getSubweabesByType(Type $type)
    {
        
    }

    public function getTypeVariants(String $slug)
    {
        $type = Type::where('slug','=',$slug)->get();

        return VariantIndexResource::collection(
            $type[0]->variants
        );
    }
}
