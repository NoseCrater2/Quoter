<?php

namespace App\Http\Controllers\Api;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Color;
use App\Http\Resources\VariantIndexResource;
use App\Http\Resources\TypeIndexResurce;
use Barryvdh\DomPDF\Facade as PDF;


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
        $variants = $product->variants()
        ->with(['type:id,name', 'line:id,name', 'weave:id,name', 'subweave:id,name'])
        ->orderBy('price','desc')
        ->get();
        return response(['data'=> $variants],200);
    }

    public function exportPdf(Request $request)
    {
        //Recuperar el request en un objeto
        $orders = $request->all();
        $pdf = PDF::loadView('pdf.orderclient', compact('orders'));

        return $pdf->download('order-list.pdf');
    }

    public function exportPdfDistributor(Request $request)
    {
        //Recuperar el request en un objeto
        $orders = $request->all();
        $pdf = PDF::loadView('pdf.orderdistributor', compact('orders'));

        return $pdf->download('order-list.pdf');
    }

    public function authExportPdf(Request $request)
    {
        //Recuperar el request en un objeto
        $orders = $request->all();
        $pdf = PDF::loadView('pdf.orderadmin', compact('orders'));

        return $pdf->download('order-list.pdf');
    }



}
