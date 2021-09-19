<?php

namespace App\Http\Controllers;

use App\Blind;
use App\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;

class BlindController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
     * @param  \App\Blind  $blind
     * @return \Illuminate\Http\Response
     */
    public function show(Blind $blind)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Blind  $blind
     * @return \Illuminate\Http\Response
     */
    public function edit(Blind $blind)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Blind  $blind
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blind $blind)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Blind  $blind
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blind $blind)
    {
        $blind->delete();
        return response(['messagge'=> 'La persiana se eliminó'],200);
    }

    public function revalidateItemQuotation(Request $request, Order $order){
        // dd($request->all());
        $data = $request->all();
        foreach ($data as $value) {
            $blind = Blind::find($value['id']);
            $blind->price = $value['price'];
            $order->blinds()->save($blind);
        }
        $order->updated_at = Carbon::now()->format('Y-m-d H:i:s');
        $order->save();

    }

}
