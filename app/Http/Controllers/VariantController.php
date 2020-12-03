<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\ErrorMessages;
use App\Exports\VariantsExport;
use App\Variant;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\VariantsImport;
use App\Http\Resources\VariantIndexResource;
use App\Http\Resources\VariantShowResource;
use App\Http\Resources\ColorIndexResource;
use App\Imports\ModelsImport;
use App\Sunblind;
use Carbon\Carbon;
use Spatie\Searchable\Search;
use Spatie\Searchable\ModelSearchAspect;

class VariantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return VariantIndexResource::collection(
            Variant::get()
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
     * @param  \App\Variant  $variant
     * @return \Illuminate\Http\Response
     */
    public function show(Variant $variant)
    {
        return new VariantShowResource(Variant::findOrFail($variant->id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Variant  $variant
     * @return \Illuminate\Http\Response
     */
    public function edit(Variant $variant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Variant  $variant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Variant $variant)
    {
        $data = $request->all();
        $rules = [
             'price' => 'required|numeric|min:1',
         ];
         $validator= Validator::make($data,$rules, ErrorMessages::getMessages());
         
         if($validator->fails()){
             return response($validator->errors(),422);
         }else{
             
             $variant->price = $data['price']; 
             $variant->save();
             return new VariantIndexResource(Variant::findOrFail($variant->id));
         }   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Variant  $variant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Variant $variant)
    {
        //
    }

    public function importExcel(Request $request)
    {
        $file = $request->file('file');
        $import = new VariantsImport;

        $import->import($file);
        //Excel::import(new VariantsImport, );
        if($import->failures()->isNotEmpty()){
           return response($import->failures());
        }
    }

    public function getRelated(Variant $variant)
    {
        return VariantIndexResource::collection(
            Variant::orderByRaw('rand()')->where('type_id', '=', $variant->type->id)->take(4)->get()
        );
                
    }

    public function getColors(Variant $variant)
    {
        return ColorIndexResource::collection(
            $variant->colors
        );
    }

    public function exportExcel()
    {
        $date = Carbon::now()->toDateString();
        return Excel::download( new VariantsExport, 'modelos '.$date.'.xlsx');
    }

    public function importModels(Request $request)
    {
        $file = $request->file('file');
        $import = new ModelsImport;

        $import->import($file);
        //Excel::import(new VariantsImport, );
        if($import->failures()->isNotEmpty()){
           return response($import->failures());
        }
    }

    public function getSearch(Request $request)
    {
       $results = (new Search())
       ->registerModel(Variant::class, function(ModelSearchAspect $modelSearchAspect){
           $modelSearchAspect
           ->addSearchableAttribute('name')
           ->addSearchableAttribute('price')
           ->with('colors');
       })
       ->registerModel(Sunblind::class, function(ModelSearchAspect $modelSearchAspect){
        $modelSearchAspect
        ->addSearchableAttribute('name')
        ->addSearchableAttribute('price')
        ->with('colors');
    })
       //Aquí de pueden añadir mas modelos y el array indica los atributos por los que se pueden buscar
       ->search($request->input('query'));

       return response()->json($results);
    }
}
