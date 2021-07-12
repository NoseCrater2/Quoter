<?php

namespace App\Http\Controllers;

use App\User;
use App\Blind;
use App\Canvas;
use App\Order;
use App\ErrorMessages;
use App\Http\Resources\OrderIndexResource;
use App\Http\Resources\OrderShowResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::find(auth()->user()->id);

        return OrderIndexResource::collection(
           $user->orders()->where('is_quotation',false)->get()
        );
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $rules =[
            "is_quotation" => 'required|boolean',
            "orders"    => "required",
        ];

        $validator= Validator::make($data,$rules, ErrorMessages::getMessages());
        
        if($validator->fails()){
            return response($validator->errors(),422);
            
        }else{
            $order = new Order();
            $order->user_id = auth()->user()->id;
            $order->is_quotation = $data['is_quotation'];
            $order->save();

            foreach ($data['orders'] as $b) {
                $blind = new Blind();
                $blind->order_id = $order->id;
                $blind->variant_id = $b['variant'];
                $blind->color_id = $b['color']['id'];
                $blind->cloth_holder = $b['cloth_holder'];
                $blind->control_side = $b['motor']['side_control'];
                $blind->panels = $b['motor']['panels'];
                $blind->grouping = $b['motor']['selected_panel'];
                $blind->manufacturer = $b['motor']['manufacturer'];
                $blind->string_type = $b['motor']['string_type'];
                $blind->gallery_id = $b['motor']['gallery']['id'];
                $blind->motorization_id = $b['motor']['motor'];
                $blind->control_id = $b['motor']['control']['id'];
                $blind->second_variant_id = $b['variant2'];
                $blind->second_color_id = $b['second_color']['id'];
                $blind->celular_drive = $b['celular_drive'];
                $blind->celular_type = $b['celular_type'];
                $blind->celular_variant = $b['celular_variant'];
                $blind->instalation_side = $b['instalation_side'];
                $blind->motor_type = $b['motor_type'];
                $blind->price = $b['price'];
                $blind->rotate = $b['rotate'];
                $blind->canvas = $b['motor']['canvas'];
                $blind->comment = $b['motor']['comment'];
                $blind->drive = $b['motor']['drive'];
                $blind->flexiballet_price = $b['motor']['flexiballetPrice'];
                $blind->frame = $b['motor']['frame'];
                $blind->gallery_price = $b['motor']['galleryPrice'];
                $blind->height_control = $b['motor']['height_control'];
                $blind->motor_instalation_side = $b['motor']['instalation_side'];
                $blind->manufacturer_price = $b['motor']['manufacturerPrice'];
                $blind->control_price = $b['motor']['price'];
                $blind->rail_color = $b['motor']['rail_color'];
                $blind->string_price = $b['motor']['stringPrice'];
                $blind->save();

                foreach ($b['canvas'] as $c) {
                    $canvas = new Canvas();
                    $canvas->blind_id = $blind->id;
                    $canvas->width = $c['width'];
                    $canvas->height = $c['height'];
                    $canvas->save();
                }
            }


        
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return new OrderShowResource($order);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $data = $request->all();
        $rules =[
            "orders"    => "required",
        ];

        $validator= Validator::make($data,$rules, ErrorMessages::getMessages());

        if($validator->fails()){

            return response($validator->errors(),422);
            
        }else{
            if(isset($data['is_quotation'])){
                $order->is_quotation = $data['is_quotation'];
                $order->save();
            }
          
            foreach ($data['orders'] as $b) {
                $blind = Blind::find($b['id']);
                $blind->variant_id = $b['variant'];
                $blind->color_id = $b['color']['id'];
                $blind->cloth_holder = $b['cloth_holder'];
                $blind->control_side = $b['motor']['side_control'];
                $blind->panels = $b['motor']['panels'];
                $blind->grouping = $b['motor']['selected_panel'];
                $blind->manufacturer = $b['motor']['manufacturer'];
                $blind->string_type = $b['motor']['string_type'];
                $blind->gallery_id = $b['motor']['gallery']['id'];
                $blind->motorization_id = $b['motor']['motor'];
                $blind->control_id = $b['motor']['control']['id'];
                $blind->second_variant_id = $b['variant2'];
                $blind->second_color_id = $b['second_color']['id'];
                $blind->celular_drive = $b['celular_drive'];
                $blind->celular_type = $b['celular_type'];
                $blind->celular_variant = $b['celular_variant'];
                $blind->instalation_side = $b['instalation_side'];
                $blind->motor_type = $b['motor_type'];
                $blind->price = $b['price'];
                $blind->rotate = $b['rotate'];
                $blind->canvas = $b['motor']['canvas'];
                $blind->comment = $b['motor']['comment'];
                $blind->drive = $b['motor']['drive'];
                $blind->flexiballet_price = $b['motor']['flexiballetPrice'];
                $blind->frame = $b['motor']['frame'];
                $blind->gallery_price = $b['motor']['galleryPrice'];
                $blind->height_control = $b['motor']['height_control'];
                $blind->motor_instalation_side = $b['motor']['instalation_side'];
                $blind->manufacturer_price = $b['motor']['manufacturerPrice'];
                $blind->control_price = $b['motor']['price'];
                $blind->rail_color = $b['motor']['rail_color'];
                $blind->string_price = $b['motor']['stringPrice'];
                $blind->save();
                $blind->canvases()->delete();

                foreach ($b['canvas'] as $c) {
                    $canvas = new Canvas();
                    $canvas->blind_id = $blind->id;
                    $canvas->width = $c['width'];
                    $canvas->height = $c['height'];
                    $canvas->save();
                }
            }

            return new OrderIndexResource($order);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->blinds()->delete();
        $order->delete();
        return new OrderIndexResource($order);
    }

    public function quotations()
    {
        $user = User::find(auth()->user()->id);

        return OrderIndexResource::collection(
           $user->orders()->where('is_quotation',true)->get()
        );

    }

    public function changeToOrder(Order $order)
    {
        $order->is_quotation = 0;
        $order->save();
        return new OrderIndexResource($order);
    }

    
}
