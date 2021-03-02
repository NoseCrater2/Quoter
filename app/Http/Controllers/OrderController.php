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
           $user->orders
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
        $data = $request->all();
        $rules =[
            "orders"    => "required",
        ];

        $validator= Validator::make($data,$rules, ErrorMessages::getMessages());
        
        if($validator->fails()){
            return response($validator->errors(),422);
            
        }else{
            $order = new Order();
            $order->user_id = auth()->user()->id;
            $order->subtotal = 1000;
            $order->total = 10000;
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
        return new OrderShowResource(Order::findOrFail($order->id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
