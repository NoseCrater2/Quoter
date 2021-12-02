<?php

namespace App\Http\Controllers;

use App\User;
use App\Blind;
use App\Canvas;
use App\Order;
use App\ErrorMessages;
use App\Http\Resources\AdministratorOrderIndexResource;
use App\Http\Resources\AdministratorQuotationIndexResource;
use App\Http\Resources\OrderIndexResource;
use App\Http\Resources\QuotatioIndexResource;
use App\Http\Resources\OrderShowResource;
use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Notifications\OrderState;
use Illuminate\Support\Facades\Mail;
use App\Mail\BuyedOrderAdmin;
use App\Mail\BuyedOrderClient;
use Carbon\Carbon;

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
            $user->orders()->where('is_quotation',false)->orderBy('created_at', 'desc')->get()
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
            DB::transaction(function () use ($data) {
                $order = new Order();
                $order->user_id = auth()->user()->id;
                $order->is_quotation = $data['is_quotation'];
                $order->save();

                foreach ($data['orders'] as $b) {
                    $blind = new Blind();
                    $blind->order_id = $order->id;
                    $blind->variant = $b['variant'];
                    $blind->type = $b['type'];
                    $blind->manufacturer = $b['manufacturer'];
                    $blind->line = $b['line'];
                    $blind->color_id = $b['color']['id'];
                    $blind->cloth_holder = $b['cloth_holder'];
                    $blind->control_side = $b['motor']['side_control'];
                    $blind->panels = $b['motor']['panels'];
                    $blind->grouping = $b['motor']['selected_panel'];
                    $blind->motor_manufacturer = $b['motor']['manufacturer'];
                    $blind->string_type = $b['motor']['string_type'];
                    if(isset($b['motor']['gallery']['id'])){
                        $blind->gallery_id = $b['motor']['gallery']['id'];
                    }
                    $blind->motorization_id = $b['motor']['motor'];
                    if(isset($b['motor']['control']['id'])){
                        $blind->control_id = $b['motor']['control']['id'];
                    }
                    $blind->second_variant = $b['variant2'];
                    if(isset($b['second_color']['id'])){
                        $blind->second_color_id = $b['second_color']['id'];
                    }
                    $blind->celular_drive = $b['celular_drive'];
                    $blind->celular_type = $b['celular_type'];
                    $blind->celular_variant = json_encode($b['celular_variant']);
                    $blind->instalation_side = $b['instalation_side'];
                    $blind->motor_type = $b['motor_type'];
                    $blind->price = $b['price'];
                    $blind->base_price = $b['base_price'];
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
                    $blind->extraEnrollable = $b['extraEnrollable'];
                    $blind->extraVertical = $b['extraVertical'];

                    // this.order.discount_price = this.order.price - ((this.user.discount_percent/100)*this.order.price)
                    $blind->discount_price = $b['price'] - ((auth()->user()->discount_percent/100)*$b['price']);

                    $blind->installmentCharge = $b['installmentCharge'];

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
            });

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
                $blind->variant = $b['variant'];//
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
                $blind->second_variant = $b['variant2'];//
                $blind->second_color_id = $b['second_color']['id'];
                $blind->celular_drive = $b['celular_drive'];
                $blind->celular_type = $b['celular_type'];
                $blind->celular_variant = json_encode($b['celular_variant']);
                $blind->instalation_side = $b['instalation_side'];
                $blind->motor_type = $b['motor_type'];
                $blind->base_price = $b['base_price'];
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
                $blind->extraEnrollable = $b['extraEnrollable'];
                $blind->extraVertical = $b['extraVertical'];

                $blind->discount_price = $b['price'] - ((auth()->user()->discount_percent/100)*$b['price']);

                $blind->installmentCharge = $b['installmentCharge'];

                $blind->save();
                $blind->canvases()->delete();

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

        return QuotatioIndexResource::collection(
            $user->orders()->where('is_quotation',true)->orderBy('created_at', 'desc')->get()
        );

    }

    public function quotationsAdmin()
    {
        return AdministratorQuotationIndexResource::collection(
            Order::where('is_quotation',true)->orderBy('created_at', 'desc')->get()
         );
         //Order::where('is_quotation',true)->whereHas('user', function($query){$query->;})->get();
    }

    public function ordersAdmin()
    {
        return AdministratorOrderIndexResource::collection(
            Order::where('is_quotation',false)->orderBy('created_at', 'desc')->get()
         );
    }

    public function changeToOrder(Order $order)
    {
        $order->is_quotation = 0;
        $order->state = 'No Pagada';
        $order->save();
        return new OrderIndexResource($order);
    }

    public function buy(Request $request, Order $order)
    {
        $data = $request->all();
        $rules =[
            'bank_account' => 'required|string',
            'clabe' => 'required|string',
            'name_account' => 'required|string',
        ];

        $validator= Validator::make($data,$rules, ErrorMessages::getMessages());

        if($validator->fails()){
            return response($validator->errors(),422);

        }else{
            DB::transaction(function () use ($data, $order) {
                $order->state = "Recibida";
                $ticket = new Ticket();
                $ticket->bank_account = $data['bank_account'];
                $ticket->clabe = $data['clabe'];
                $ticket->name_account = $data['name_account'];
                $order->ticket()->save($ticket);

            });
            return response(['message'=>'Payed!'],200);
        }

    }

    public function changeState(Request $request, Order $order)
    {
        $state = $request['state'];
        $order->state = $state;
        $order->save();

        $distributor = User::find($order->user_id);

        $distributor->notify( new OrderState($order));

        return response(['message'=>'Changed!'],200);
    }

    public function removeOrderMarketcar(Order $order)
    {
        $order->is_quotation = 1;
        $order->save();
        return response(['message'=>'Changed!'],200);
    }

    public function removeAllOrdersMarketcar()
    {
       $orders = auth()->user()->orders;

       $orders->where('state', 'No Pagada')->each(function ($order)
       {
           $order->is_quotation = 1;
           $order->save();
       });

    }

    public function speiPayment(Order $order)
    {
       $newOrder = Order::find($order->id);
       $newOrder->state = 'En Verificacion';
       $newOrder->save();
       Mail::to(['sac1@rollux.com.mx', 'distribuidores@rollux.com.mx'])->send(new BuyedOrderAdmin($newOrder));
       Mail::to($newOrder->user->email)->send(new BuyedOrderClient($newOrder));
    }

    public function cronMarketcarValidOrder()
    {
        $orders = Order::all();
        foreach ($orders as $order) {
            if(!$order->is_quotation && Carbon::now()->diffInDays($order->updated_at, true) > 20){
                $order->is_quotation = 1;
                $order->save();
            }
        }
    }

    public function executeActionsAllorders(Request $request, String $action){
        $idOrders = $request->orders;

        if($action == 'delete'){
            Order::destroy($idOrders);
        }
        else if($action != 'delete'){
            foreach ($idOrders as $id) {
                Order::where('id', $id)
                ->update(['state' => $action]);
            }
        }

    }
}
