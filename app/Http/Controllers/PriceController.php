<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Price;
use Illuminate\Support\Facades\Storage;
use App\ErrorMessages;
use Illuminate\Support\Facades\Validator;

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
        $data = $request->all();
        $rules =[
            'title' => 'required|string|max:255',
            // 'email' => 'required|string|email|max:255|unique:users',
            // 'rfc' => 'nullable|string|size:13',
        ];

        $validator= Validator::make($data,$rules, ErrorMessages::getMessages());

        if($validator->fails()){
            return response($validator->errors(),422);

        }else{
           if($request->hasFile('file')){
                $data['path'] = $request->file->store('pdfs/archivos',);
           }
           if($request->hasFile('thumbnail')){
                $data['thumbnail'] = $request->thumbnail->store('pdfs/thumbnails');
            }
            
           $price = Price::create($data);
           return $price;
            //return new UserIndexResource(User::findOrFail($user->id));
        }
    }

    public function update(Request $request, Price $price)
    {
        $data = $request->all();
        $rules =[
            'title' => 'string|max:255',
        ];

        $validator= Validator::make($data,$rules, ErrorMessages::getMessages());

        if($validator->fails()){
            return response($validator->errors(),422);

        }else{
           if($request->hasFile('file')){
                Storage::delete($price->path);
                $data['path'] = $request->file->store('pdfs/archivos');
           }
           if($request->hasFile('thumbnail')){
                Storage::delete($price->thumbnail);
                $data['thumbnail'] = $request->thumbnail->store('pdfs/thumbnails');
            }
            
           $price->update($data);
           return $price;
        }
    }

    public function destroy(Price $price)
    {
        Storage::delete($price->path);
        Storage::delete($price->thumbnail);
        $price->delete();
        return $price;
    }

}
