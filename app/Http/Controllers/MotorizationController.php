<?php

namespace App\Http\Controllers;

use App\Motorization;
use App\Line;
use App\MotorizationType;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MotorizationImport;
use App\Http\Resources\IndexMotorizationResource;
use App\Type;

class MotorizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $motorizations = Motorization::select('id','code','canvas','system','width','height','price','via')
        ->addSelect(
            ['motorizationType' => MotorizationType::select('name')
            ->whereColumn('motorization_type_id', 'motorization_types.id')],
        )
        ->addSelect(
            ['type' => Type::select('name')
            ->whereColumn('type_id', 'types.id')],
        )
        ->addSelect(
            ['manufacturer' => Line::select('name')
            ->whereColumn('line_id', 'lines.id')],
        )
        ->get();
        return response(['data'=> $motorizations],200);  
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
     * @param  \App\Motorization  $motorization
     * @return \Illuminate\Http\Response
     */
    public function show(Motorization $motorization)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Motorization  $motorization
     * @return \Illuminate\Http\Response
     */
    public function edit(Motorization $motorization)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Motorization  $motorization
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Motorization $motorization)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Motorization  $motorization
     * @return \Illuminate\Http\Response
     */
    public function destroy(Motorization $motorization)
    {
        //
    }

    public function importMotorizations(Request $request)
    {
        $file = $request->file('file');
        $import = new MotorizationImport;

        $import->import($file);
        //Excel::import(new VariantsImport, );
        if($import->failures()->isNotEmpty()){
           return response($import->failures());
        }
    }

    public function getFilteredMotorizations(Type $type)
    {
        return IndexMotorizationResource::collection(
            Motorization::where('type_id', '=', $type->id)->get()
        );   
    }
}
