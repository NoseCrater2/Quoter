<?php

namespace App\Http\Controllers\Api;

use App\Product;
use App\Color;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\ProductIndexResource;
use App\Http\Resources\VariantIndexResource;
use App\Http\Resources\TypeIndexResurce;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Database\Eloquent\Builder;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with(['types' => function ($query) {
            $query->with(['weaves:slug,name','lines:id,slug,name']);
        }])->get();
        return response(['data'=> $products],200);
        

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = Product::create($request->all());

        return redirect()->route('products.edit',$product->id)
            ->with('info','Producto guardado con éxito');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product->update($request->all());

        return redirect()->route('products.edit',$product->id)
            ->with('info','Producto actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return back()->with('info', 'Eliminado correctamente');
    }

    public function getVariants(Product $product)
    {

        return VariantIndexResource::collection(
             $product->variants
        );
        
    }

    public function getTypes(Product $product){
    
        return TypeIndexResurce::collection(
            $product->types
       );
    }

    public function getVariantsByProduct(Product $product)
    {
        $variants = $product->variants()->addSelect(
            ['image' => Color::select('code')->limit(1)],
        )
        ->with(['type:id,slug','line:id,slug','weave:id,slug'])
        ->orderBy('price','desc')
        ->get();
        return response(['data'=> $variants],200);
    }

    public function exportPdf(Request $request)
    {
        //Recuperar el request en un objeto
        // $orders = $request->all();
        $orders = [];
    //    dd($orders[0]['type']);
        $pdf = PDF::loadView('pdf.order', compact('orders'));

        return $pdf->stream('order-list.pdf');
    }

 

}
