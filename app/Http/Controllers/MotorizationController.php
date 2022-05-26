<?php

namespace App\Http\Controllers;

use App\Motorization;
use App\Line;
use App\MotorizationType;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MotorizationImport;
use App\Exports\MotorizationExport;
use App\Http\Resources\IndexMotorizationResource;
use App\Type;
use Illuminate\Support\Facades\Validator;
use App\ErrorMessages;

class MotorizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $motorizations = Motorization::select('id','code','canvas','system','width','height','price','via','type_id','line_id','motorization_type_id')
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
        ->where('active',1)
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
        $data = $request->all();
        $rules = [
            'code' => 'required',
            'canvas' => 'required',
            'system' => 'required',
            'width' => 'required',
            'height' => 'required',
            'price' => 'required|numeric',
            'via' => 'required',
            'motorization_type_id' => 'required|exists:motorization_types,id',
            'line_id' => 'required|exists:lines,id',
            'type_id' => 'required|exists:types,id',
        ];

        $validator= Validator::make($data,$rules, ErrorMessages::getMessages());
        if($validator->fails()){
            return response($validator->errors(),422);
        }else{

            $motorization->update($data);
            return Motorization::select('id','code','canvas','system','width','height','price','via','type_id','line_id','motorization_type_id')
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
            ->where('active',1)
            ->where('id', $motorization->id)
            ->first();
        }

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

    public function exportMotorizations()
    {

        return Excel::download( new MotorizationExport, 'motores.xlsx');
    }

    public function getFilteredMotorizations(Type $type)
    {
        return IndexMotorizationResource::collection(
            Motorization::where('type_id', '=', $type->id)->get()
        );
    }
}
