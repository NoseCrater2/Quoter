<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\ErrorMessages;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Catalog;

class CatalogController extends Controller
{
    public function index()
    {
        return Catalog::all();
    }


    public function show(Catalog $catalog)
    {
        //return Catalog::all();
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
            
           $catalog = Catalog::create($data);
           return $catalog;
            //return new UserIndexResource(User::findOrFail($user->id));
        }
    }

    public function update(Request $request, Catalog $catalog)
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
                Storage::delete($catalog->path);
                $data['path'] = $request->file->store('pdfs/archivos');
           }
           if($request->hasFile('thumbnail')){
                Storage::delete($catalog->thumbnail);
                $data['thumbnail'] = $request->thumbnail->store('pdfs/thumbnails');
            }
            
           $catalog->update($data);
           return $catalog;
        }
    }

    public function destroy(Catalog $catalog)
    {
        Storage::delete($catalog->path);
        Storage::delete($catalog->thumbnail);
        $catalog->delete();
        return $catalog;
    }
}
