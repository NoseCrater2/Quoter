<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Price;

class PriceController extends Controller
{
    public function index()
    {
        return Price::all();
    }


    public function show(Price $price)
    {
        return Price::all();
    }

    public function store(Request $request)
    {
        return Price::all();
    }

    public function update(Request $request, Price $price)
    {
        return Price::all();
    }

    public function destroy(Price $price)
    {
        return Price::all();
    }

}
