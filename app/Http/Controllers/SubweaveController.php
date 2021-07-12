<?php

namespace App\Http\Controllers;

use App\Subweave;
use Illuminate\Http\Request;

class SubweaveController extends Controller
{
    public function index()
    {
        $subweaves = Subweave::with(['weaves:id,name,slug','line:id,slug','type:id,slug'])->get();
        return response(['data'=> $subweaves],200);
    }
}
