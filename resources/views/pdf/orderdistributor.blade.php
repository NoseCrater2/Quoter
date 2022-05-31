<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title></title>
    <style>
        /* !! $counter->name.' '.$counter->type->name.' '.$counter->line->name.' '.$counter->manufacturers->first()->name !! */
        *{
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        .vertical{
            white-space: nowrap;
            font-size: 10px;
            font-weight: bold;
            color: #418686;
        }

        .vertical > div {
            transform:
            /* Magic Numbers */
            translate(0px, -7px)
            /* 45 is really 360 - 45 */
            rotate(270deg);
            margin: -20px -40px;
        }
    </style>
</head>
<body style="margin-top: 20px;">
    <?php


function returnedOneTwoOrders($localIndex, $localorders) {
            $multiX2 = $localIndex * 2;
            return array_slice($localorders, ($multiX2 - 2), 2);
        }
        $user = null; //Se declara usuario null
        if(isset($orders['user']['id'])){ //Si el usuario que llega tiene id
            $user = App\User::find($orders['user']['id']); //Existe y se busca en bd
        }
        else{
            $user = $orders['user']; //No existe, y se asigna el que llega
        }
        $date = new Carbon\Carbon;
        $total = 0;
        setlocale(LC_MONETARY, 'es_MX');
        $countBlinds = 1;
        // $blindVariant1 = App\Variant::find(4137);
    ?>
    <table style="border-collapse:collapse; width: 100%; margin-top: -13px">
        <tbody>
            @if(isset($orders['user']['id']))
            <tr>
                <td style="width: 20%; padding-top: -13px; padding-left: 9px; height: 124px; border-right: solid #47a5ad 4px; ">
                    <img width="180px" src="img/logos/rollux.png" >
                </td>
                <td style="text-align: center; width: 53%; padding-right: 5px; padding-left: 7px; padding-top: 11px;">
                    <div style="border-left: solid #47a5ad 4px; padding-top: 7px;">
                    </div>
                    <table style="width: 100%; border: 1px solid #d1d3d4; border-radius: 5px; margin-left: 9px; padding-bottom: 11px;">
                        <tbody>
                            <tr>
                                <th colspan="2" style="background-color: #d1d3d4; padding-top: 3px; padding-bottom: 3px;">
                                    @if(array_key_exists('company', $orders['user']))
                                        @if($orders['user']['company'] != null || $orders['user']['company'] != '')
                                            <div style="font-weight: bolder; font-size: 13px;">{!! $orders['user']['company'] !!} | <span style="font-weight: normal;">Distribuidor Autorizado</span></div>
                                        @else
                                            <div style="font-weight: bolder; font-size: 13px;">{!! $orders['user']['name'].' '.$orders['user']['last_name'] !!} | <span style="font-weight: normal;">Distribuidor Autorizado</span></div>
                                        @endif
                                    @else
                                        <div style="font-weight: bolder; font-size: 13px;">{!! $orders['user']['name'].' '.$orders['user']['last_name'] !!} | <span style="font-weight: normal;">Distribuidor Autorizado</span></div>
                                    @endif
                                </th>
                            </tr>
                            <tr>
                                <td style="width: 45%; padding-left: 13px;">
                                    <div class="d-block" style="font-weight: bolder; margin-top: 3px;" >Cotización</div>
                                    <div class="d-block" style="font-size: 12px;">Folio <span style="font-weight: bolder; color: #47a5ad">R{!! $date->now()->format('dmY') !!}/001</span></div>
                                    <div class="d-block" style="font-size: 12px;">Fecha: {!! $date->now()->format('d/m/Y'); !!}</div>
                                    <div class="d-block" style="font-size: 12px;">Valida hasta: {!! $date->addDays(20)->format('d/m/Y'); !!}</div>
                                </td>
                                <td style="width: 55%;">
                                    <div style="font-size: 9px; margin-top: 1px;">
                                        @if(array_key_exists('company', $orders['user']))
                                            @if($orders['user']['company'] != null || $orders['user']['company'] != '')
                                                <div style="font-weight: bolder;">Cliente: {!! $orders['user']['name'].' '.$orders['user']['last_name'] !!}</div>
                                            @endif
                                        @endif
                                        @if(array_key_exists('ship_address', $orders['user']))
                                            @if($orders['user']['ship_address'] != null || $orders['user']['ship_address'] != '')
                                                <div>
                                                    <span>Dirección: {!! $orders['user']['ship_address'] !!}</span>
                                                </div>
                                            @endif
                                        @endif
                                        @if(array_key_exists('rfc', $orders['user']))
                                            @if($orders['user']['rfc'] != null || $orders['user']['rfc'] != '')
                                                <div>
                                                    <span>RFC: {!! $orders['user']['rfc'] !!}</span>
                                                </div>
                                            @endif
                                        @endif
                                        @if(array_key_exists('phone', $orders['user']))
                                            @if($orders['user']['phone'] != null || $orders['user']['phone'] != '')
                                                <div>
                                                    <span>Teléfono: {!! $orders['user']['phone'] !!}</span>
                                                </div>
                                            @endif
                                        @endif
                                        @if(array_key_exists('email', $orders['user']))
                                            @if($orders['user']['email'] != null || $orders['user']['email'] != '')
                                                <div>
                                                    <span>Email: {!! $orders['user']['email'] !!}</span>
                                                </div>
                                            @endif
                                        @endif
                                        <!-- <div>Embarcado por:</div>
                                        <div>Fecha de entrega:</div>
                                        <div>Realizado por: RolluxWeb</div> -->
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td style="width: 25%;">
                @if(array_key_exists('logo', $orders['user']))
                    @if (File::exists('img/'.$orders['user']['logo']))
                        <img width="180px" src="{{'img/'.$orders['user']['logo']}}" >
                    @endif
                @endif
                </td>
            </tr>
            @else
            <tr>
                <td style="width: 32%; padding-top: -13px; height: 30px;">
                        <table style="width: 100%; height: 30px;">
                            <tbody>
                                <tr>
                                    <td style="width: 20%; border-right: solid #47a5ad 4px;">
                                        <img width="120px" src="img/color-r.png" />
                                    </td>
                                    <td style="width: 80%; padding-left: 13px;">
                                        <div class="d-block" style="font-size: 11px; font-weight: bolder; margin-top: 3px;" >Cotización</div>
                                        <div class="d-block" style="font-size: 10px;">Folio <span style="font-weight: bolder; color: #47a5ad">R200421/001</span></div>
                                        <div class="d-block" style="font-size: 10px;">Fecha: {!! $date->now()->format('d/m/Y'); !!}</div>
                                        <div class="d-block" style="font-size: 10px;">Valida hasta: {!! $date->addDays(8)->format('d/m/Y'); !!}</div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                </td>
                <td style="width: 43%;  padding-top: 11px;">
                    <table style="width: 100%; border: 1px solid #d1d3d4; border-radius: 5px; margin-left: 9px; padding-bottom: 11px;">
                        <tbody>
                            <tr>
                                <th style="background-color: #d1d3d4; padding-top: 3px; padding-bottom: 3px;">
                                    @if(isset($user['company']))
                                        @if($user['company'] != null || $user['company'] != '')
                                            <div style="font-weight: bolder; font-size: 9px;">{!! $user['company'] !!} | <span style="font-weight: normal; font-size: 8px; font-style: italic;">Distribuidor Autorizado</span></div>
                                        @else
                                            <div style="font-weight: bolder; font-size: 9px;">{!! $user['name'].' '.$user['last_name'] !!} | <span style="font-weight: normal; font-size: 8px; font-style: italic;">Distribuidor Autorizado</span></div>
                                        @endif
                                    @else
                                        <div style="font-weight: bolder; font-size: 9px;">{!! $user['name'].' '.$user['last_name'] !!} | <span style="font-weight: normal; font-size: 8px; font-style: italic;">Distribuidor Autorizado</span></div>
                                    @endif
                                </th>
                                <th style="background-color: #EEEEEE; padding-top: 3px; padding-bottom: 3px;">
                                    <div style="font-weight: bolder; font-size: 9px;">Consignatario</span></div>
                                </th>
                            </tr>
                            <tr>
                                <td style="width: 55%;">
                                    <div style="font-size: 8px; margin-top: 1px; padding-left: 5px;">
                                        @if(isset($user['company']))
                                            @if($user['company'] != null || $user['company'] != '')
                                                <div style="font-weight: bolder;">Asesor: {!! $user['name'].' '.$user['last_name'] !!}</div>
                                            @endif
                                        @endif
                                        @if(isset($user['ship_address']))
                                            @if($user['ship_address'] != null || $user['ship_address'] != '')
                                                <div>
                                                    <span>Dirección: {!! $user['ship_address'] !!}</span>
                                                </div>
                                            @endif
                                        @endif
                                        @if(isset($user['rfc']))
                                            @if($user['rfc'] != null || $user['rfc'] != '')
                                                <div>
                                                    <span>RFC: {!! $user['rfc'] !!}</span>
                                                </div>
                                            @endif
                                        @endif
                                        @if(isset($user['phone']))
                                            @if($user['phone'] != null || $user['phone'] != '')
                                                <div>
                                                    <span>Teléfono: {!! $user['phone'] !!}</span>
                                                </div>
                                            @endif
                                        @endif
                                        @if(isset($user['email']))
                                            @if($user['email'] != null || $user['email'] != '')
                                                <div>
                                                    <span>Email: {!! $user['email'] !!}</span>
                                                </div>
                                            @endif
                                        @endif
                                        <!-- <div>Embarcado por:</div>
                                        <div>Fecha de entrega:</div>
                                        <div>Realizado por: RolluxWeb</div> -->
                                    </div>
                                </td>
                                <td style="width: 45%;">
                                    <div style="font-size: 7px; margin-top: 1px; padding-left: 5px;">
                                        <div style="font-weight: bolder; font-size: 8px;">{!! $orders['user']['name'].' '.$orders['user']['last_name'] !!}</div>
                                        @if(array_key_exists('ship_address', $orders['user']))
                                            @if($orders['user']['ship_address'] != null || $orders['user']['ship_address'] != '')
                                                <div>
                                                    <span>Dirección: {!! $orders['user']['ship_address'] !!}</span>
                                                </div>
                                            @endif
                                        @endif
                                        @if(array_key_exists('rfc', $orders['user']))
                                            @if($orders['user']['rfc'] != null || $orders['user']['rfc'] != '')
                                                <div>
                                                    <span>RFC: {!! $orders['user']['rfc'] !!}</span>
                                                </div>
                                            @endif
                                        @endif
                                        @if(array_key_exists('phone', $orders['user']))
                                            @if($orders['user']['phone'] != null || $orders['user']['phone'] != '')
                                                <div>
                                                    <span>Teléfono: {!! $orders['user']['phone'] !!}</span>
                                                </div>
                                            @endif
                                        @endif
                                        @if(array_key_exists('email', $orders['user']))
                                            @if($orders['user']['email'] != null || $orders['user']['email'] != '')
                                                <div>
                                                    <span>Email: {!! $orders['user']['email'] !!}</span>
                                                </div>
                                            @endif
                                        @endif
                                        <!-- <div>Embarcado por:</div>
                                        <div>Fecha de entrega:</div>
                                        <div>Realizado por: RolluxWeb</div> -->
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                </td>
                <td style="width: 23%;">
                @if(isset($user['logo']))
                    @if (File::exists('img/'.$user['logo']))
                        <img width="165px" src="{{'img/'.$user['logo']}}" >
                    @endif
                @endif
                </td>
            </tr>
            @endif
        </tbody>
    </table>
    <div style="width: 81%; font-size: 10px; text-align: center; margin: 1px auto 4px auto">
        <i>
        La emisión de este documento es solo para fines informativos y no representan ningún compromiso de fabricación para la empresa, ni para el cliente.
        Se considerará en firme cuando se realice el pago del importe acordado. Precios sujetos a cambios sin previo aviso.
        </i>
    </div>

    <table style="border-collapse:collapse; width: 100%;">

    <!-- <div style="border: 1px dashed black; height: 100px; width: 55%;display: inline-block;align-items: center">
    <div style=" height: 90px; border: 1px solid #d1d3d4; ">
    some content
    </div>
    </div> -->
    @for($i = 0; $i < (round(count($orders['orders'])/2)); $i++)
        <tr style="width: 100%;">
            @if (count($orders['orders'])%2 == 0)
                @foreach (@returnedOneTwoOrders(($i + 1), $orders['orders']) as $key => $order)
                    <td style="height: 99px; border: 1px dashed black; width: 393px;">
                        <table style="font-size: 7px; border: 1px solid #d1d3d4; background-color: #f1f1f2; margin-left: 8px; margin-right: 8px;">
                            <tbody>
                                <tr>
                                    <td class="vertical" style="width: 7%; border-right: 1px solid #d1d3d4; background-color: #f1f1f2;">
                                        <div>
                                            <span>
                                                PERSIANA {{($countBlinds++)}}
                                            </span>
                                        </div>
                                    </td>
                                    <td style="width: 60%; background-color: white;">
                                        <div style="text-transform: uppercase; margin-top: -34px;">
                                            <?php
                                                $concat = $order['type'].' // '.$order['manufacturer'];
                                                $concat2 = '';
                                                if(isset($order['line'])){
                                                    $concat .= ' // '.$order['line'];
                                                }
                                                if(isset($order['variant2'])){
                                                    $concat .= ' // [1. '.$order['variant'].'] y [2. '.$order['variant2'].'] // ';
                                                }
                                                else{
                                                    $concat .= ' // '.$order['variant'].' // ';
                                                }
                                                if(isset($order['second_color'])){
                                                    $concat .= $order['color']['color'].' // '.$order['second_color']['color'].' //';
                                                }
                                                else{
                                                    $concat .= $order['color']['color'].' //';
                                                }
                                                if($order['cloth_holder']){
                                                    $concat .= 'CON '.$order['cloth_holder'].' //';
                                                }
                                            ?>
                                            <span>{{$concat}}</span>
                                            @foreach ($order['canvas'] as $key => $canva)
                                                <?php
                                                    if(count($order['canvas']) > 1){
                                                        $concat2 .= '(L'.($key + 1).') Ancho: '.$canva['width'].'m - Alto: '. $canva['height'].'m // ';
                                                    }
                                                    else{
                                                        $concat2 .= 'Ancho: '.$canva['width'].'m - Alto: '. $canva['height'].'m // ';
                                                    }
                                                ?>
                                            @endforeach
                                            <?php
                                                if(($order['extraEnrollable']) > 0){
                                                    $concat2 .= 'Cargo extra: $'.$order['extraEnrollable'].'.00 MXN // ' ;
                                                }
                                                if(($order['extraVertical']) > 0){
                                                    $concat2 .= 'Cargo extra: $'.$order['extraVertical'].'.00 MXN // ' ;
                                                }
                                            ?>
                                            <span><strong>{{$concat2}}</strong></span>
                                            <br>
                                            <?php
                                                $concat3 = '';
                                                if($order['celular_type'] != null){
                                                    $concat3 .= $order['celular_type'].'// '.$order['celular_drive'].' // ';
                                                }
                                                if($order['motor']['selected_panel'] != null){
                                                    $concat3 .= $order['motor']['selected_panel'].' // PANELES: '.$order['motor']['panels'].' // ';
                                                }
                                                if($order['motor_type'] != null){
                                                    $concat3 .= $order['motor_type'].' // '.$order['motor']['side_control'].' // '.($order['motor']['manufacturer'] != null ? $order['motor']['manufacturer'].' // ' : '');
                                                    if($order['motor']['instalation_side'] != null){
                                                        $concat3 .= $order['motor']['instalation_side'].' // '.$order['motor']['rail_color'].' // ';
                                                    }
                                                }
                                                if($order['motor']['frame'] != null){
                                                    $concat3 .= $order['motor']['frame'].' // ';
                                                }

                                                if($order['instalation_side'] != null){
                                                    $concat3 .= $order['instalation_side'].' // ';
                                                }

                                                if($order['motor']['drive'] != null){
                                                    $concat3 .= $order['motor']['drive'].' // ';
                                                }

                                                if($order['motor']['string_type'] != null){
                                                    $concat3 .= $order['motor']['control_color'].' ';
                                                    if($order['motor']['stringPrice'] > 0){
                                                        $concat3 .= $order['motor']['manufacturer'].' (+$'.$order['motor']['stringPrice'].') // ';
                                                    }
                                                    else{
                                                        $concat3 .= ' // ';
                                                    }
                                                    $concat3 .= $order['motor']['string_type'].' // ';
                                                }

                                                if(isset($order['motor']['height_control'])){
                                                    $concat3 .= $order['motor']['height_control'].' MTS// ';
                                                }

                                                if($order['motor']['gallery'] != null){
                                                    if($order['motor']['gallery_color'] != null){
                                                        $concat3 .= $order['motor']['gallery_color'].' // ';
                                                    }
                                                    $concat3 .= $order['motor']['gallery']['model'].' ';
                                                    if($order['motor']['galleryPrice'] > 0){
                                                        $concat3 .= '(+$'.$order['motor']['galleryPrice'].') // ';
                                                    }
                                                    else{
                                                        $concat3 .= '(+$'.$order['motor']['gallery']['price'].') // ';
                                                    }
                                                }

                                                if($order['motor']['motor'] != 0 && $order['motor']['motor'] != null){
                                                    $motorization = App\Motorization::find($order['motor']['motor']);

                                                    $concat3 .= $motorization->system.' // '.$motorization->motorizationType->name.' // '.$order['motor']['manufacturer'].' ';
                                                   if($motorization->price > 0){
                                                       $concat3 .= '(+$'.$motorization->price.') // ';
                                                   }
                                                   else{
                                                       $concat3 .= '// ';
                                                   }
                                                }

                                                if($order['motor']['control'] != null){
                                                    $concat3 .= $order['motor']['control']['description'].' ';
                                                    if($order['motor']['control']['price'] > 0){
                                                        $concat3 .= '(+$'.$order['motor']['control']['price'].') // ';
                                                    }
                                                    else{
                                                        $concat3 .= ' // ';
                                                    }
                                                }

                                                if($order['motor']['flexiballetPrice'] > 0){
                                                    $concat3 .= '(+$'.$order['motor']['flexiballetPrice'].')';
                                                }
                                            ?>
                                            <span>{{$concat3}}</span>
                                            <div style="text-transform: none;">
                                                <?php
                                                    $installmentCharge = '';
                                                    if($order['installmentCharge'] > 0){
                                                        $installmentCharge .= '// CARGO POR INSTALACIÓN: $'.$order['installmentCharge'].' MXN';
                                                    }
                                                ?>
                                                <?php
                                                    $width = $order['canvas'][0]['width'] + 0;
                                                    $height = $order['canvas'][0]['height'] + 0;
                                                    $resultWidhtXHeight = 0;
                                                    $netPrice = number_format($order['price'], 2, '.', '');
                                                    if(floatval($width) < 1 && floatval($height) < 1){
                                                        $resultWidhtXHeight = 1;
                                                    }else if(floatval($width) < 1){
                                                        $resultWidhtXHeight = number_format((floatval(1) * floatval($height)), 3, '.', '');
                                                    }elseif(floatval($height) < 1){
                                                        $resultWidhtXHeight = number_format((floatval(1) * floatval($width)), 3, '.', '');
                                                    }
                                                    else{
                                                        $resultWidhtXHeight = number_format(floatval($width) * floatval($height), 3, '.', '');
                                                    }
                                                ?>
                                                 <span>Precio base (M<sup>2</sup>) ${{ $order['base_price'] }} //  M<sup>2</sup>: {{$resultWidhtXHeight}} // Precio Neto (M<sup>2</sup>): ${{$netPrice}} MXN {{$installmentCharge}} // Descuento: {{$orders['user']['discount_percent']}}% //</span>
                                                <?php
                                                    // $totaldiscount = $order['price'] - (($orders['user']['discount_percent'] / 100) * $order['price']);
                                                    $orderSum = ($order['price'] +
                                                    $order['motor']['price'] +
                                                    $order['motor']['flexiballetPrice'] +
                                                    $order['motor']['galleryPrice'] +
                                                    $order['motor']['manufacturerPrice'] +
                                                    $order['motor']['stringPrice'] +
                                                    $order['extraVertical'] +
                                                    $order['extraEnrollable']);

                                                    $totaldiscount = $orderSum - (($orders['user']['discount_percent'] / 100) * $orderSum);
                                                ?>
                                                <span>Precio neto con Descto: $@priceFormat(round($totaldiscount, 1, PHP_ROUND_HALF_UP)) MXN</span>
                                                <?php
                                                    $countSameBlinds = '';
                                                    if($order['count_same_blinds'] > 1){
                                                        $countSameBlinds = 'CANTIDAD PERSIANAS ESTE TIPO: '.$order['count_same_blinds'];
                                                    }
                                                ?>
                                                <?php
                                                    if($order['count_same_blinds'] > 1){
                                                        $countSameBlinds = 'CANTIDAD PERSIANAS ESTE TIPO: '.$order['count_same_blinds'];
                                                    }
                                                ?>
                                                <div style="color:red">{{$countSameBlinds}}</div>
                                                <?php
                                                    $coments = $order['comment'];
                                                ?>
                                                @if ($coments != null)
                                                    <div style="color:#009688">COMENTARIOS: {{$coments}}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td style="width: 33%; background-color: white;">
                                        @if ($order['second_color'] != null)
                                            <div style="margin-left: 27px; padding-top: 20px">
                                                <div style="display: inline">
                                                    @if (File::exists('img/modelos/medium/'.$order['type'].'/'.$order['manufacturer'].'/'.$order['color']['code'].'.jpg'))
                                                        <img width="43" height="43" src="{{'img/modelos/medium/'.$order['type'].'/'.$order['manufacturer'].'/'.$order['color']['code'].'.jpg'}}">
                                                    @else
                                                        <img width="43" height="43" src="img/modelos/medium-unavailable.jpg">
                                                    @endif
                                                </div>
                                                <div style="display: inline">
                                                    @if (File::exists('img/modelos/medium/'.$order['type'].'/'.$order['manufacturer'].'/'.$order['second_color']['code'].'.jpg'))
                                                        <img width="43" height="43" src="{{'img/modelos/medium/'.$order['type'].'/'.$order['manufacturer'].'/'.$order['second_color']['code'].'.jpg'}}">
                                                    @else
                                                        <img width="43" height="43" src="img/modelos/medium-unavailable.jpg">
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <div style="margin-left: 76px; padding-top: 20px">
                                                <div style="display: inline">
                                                    @if (File::exists('img/modelos/medium/'.$order['type'].'/'.$order['manufacturer'].'/'.$order['color']['code'].'.jpg'))
                                                        <img width="43" height="43" src="{{'img/modelos/medium/'.$order['type'].'/'.$order['manufacturer'].'/'.$order['color']['code'].'.jpg'}}">
                                                    @else
                                                        <img width="43" height="43" src="img/modelos/medium-unavailable.jpg">
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                        <div style="font-weight: bolder; background-color:#f1f1f2; font-size: 9.57px; text-align: right; padding-bottom: 4px; padding-top: 3px; padding-right: 4px">
                                            <span>TOTAL: </span>
                                            <span style="color: #47a5ad">
                                                <?php
                                                    // $unitaryPrice = ($order['count_same_blinds'] <= 0 ? 1 : $order['count_same_blinds']) * ($totaldiscount +
                                                    // $order['motor']['price'] +
                                                    // $order['motor']['flexiballetPrice'] +
                                                    // $order['motor']['galleryPrice'] +
                                                    // $order['motor']['manufacturerPrice'] +
                                                    // $order['motor']['stringPrice'] +
                                                    // $order['extraVertical'] +
                                                    // $order['extraEnrollable'] +
                                                    // $order['installmentCharge']);
                                                    // $total += $unitaryPrice ;
                                                    $unitaryPrice = ($order['count_same_blinds'] <= 0 ? 1 : $order['count_same_blinds']) * ($totaldiscount + $order['installmentCharge']);
                                                    $total += $unitaryPrice ;
                                                ?>
                                                $@priceFormat(round($unitaryPrice, 1, PHP_ROUND_HALF_UP)) MXN
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                @endforeach
            @else
                @foreach (@returnedOneTwoOrders(($i + 1), $orders['orders']) as $key => $order)
                    <td style="height: 99px; border: 1px dashed black; width: 393px;">
                        <table style="font-size: 6px; border: 1px solid #d1d3d4; background-color: #f1f1f2; margin-left: 8px; margin-right: 8px;">
                            <tbody>
                                <tr>
                                    <td class="vertical" style="width: 7%; border-right: 1px solid #d1d3d4; background-color: #f1f1f2;">
                                    <?php
                                        // $blindVariant1 = App\Variant::find($order['variant']);
                                        // $blindVariant2 = null;
                                        // $motorization = null;
                                        //     if ($order['variant2'] != null){
                                        //         $blindVariant2 = App\Variant::find($order['variant2']);
                                        //     }
                                        //PONER LAS IMAGENES EN CASO DE ERROR
                                    ?>
                                        <div>
                                            <span>
                                                PERSIANA {{($countBlinds++)}}
                                            </span>
                                        </div>
                                    </td>
                                    <td style="width: 60%; background-color: white;">
                                        <div style="text-transform: uppercase; margin-top: -29px;">
                                            <?php
                                                $concat = $order['type'].' // '.$order['manufacturer'];
                                                $concat2 = '';
                                                if(isset($order['line'])){
                                                    $concat .= ' // '.$order['line'];
                                                }
                                                if(isset($order['variant2'])){
                                                    $concat .= ' // [1. '.$order['variant'].'] y [2. '.$order['variant2'].'] // ';
                                                }
                                                else{
                                                    $concat .= ' // '.$order['variant'].' // ';
                                                }
                                                if(isset($order['second_color'])){
                                                    $concat .= $order['color']['color'].' // '.$order['second_color']['color'].' //';
                                                }
                                                else{
                                                    $concat .= $order['color']['color'].' //';
                                                }
                                                if($order['cloth_holder']){
                                                    $concat .= 'CON '.$order['cloth_holder'].' //';
                                                }
                                            ?>
                                            <span>{{$concat}}</span>
                                            @foreach ($order['canvas'] as $key => $canva)
                                                <?php
                                                    if(count($order['canvas']) > 1){
                                                        $concat2 .= '(L'.($key + 1).') Ancho: '.$canva['width'].'m - Alto: '. $canva['height'].'m // ';
                                                    }
                                                    else{
                                                        $concat2 .= 'Ancho: '.$canva['width'].'m - Alto: '. $canva['height'].'m // ';
                                                    }
                                                ?>
                                            @endforeach
                                            <?php
                                                if(($order['extraEnrollable']) > 0){
                                                    $concat2 .= 'Cargo extra: $'.$order['extraEnrollable'].'.00 MXN // ' ;
                                                }
                                                if(($order['extraVertical']) > 0){
                                                    $concat2 .= 'Cargo extra: $'.$order['extraVertical'].'.00 MXN // ' ;
                                                }
                                            ?>
                                            <span><strong>{{$concat2}}</strong></span>
                                            <br>
                                            <?php
                                                $concat3 = '';
                                                if($order['celular_type'] != null){
                                                    $concat3 .= $order['celular_type'].' // '.$order['celular_drive'].' // ';
                                                }
                                                if($order['motor']['selected_panel'] != null){
                                                    $concat3 .= $order['motor']['selected_panel'].' // PANELES: '.$order['motor']['panels'].' // ';
                                                }
                                                if($order['motor_type'] != null){
                                                    $concat3 .= $order['motor_type'].' // '.$order['motor']['side_control'].' // '.($order['motor']['manufacturer'] != null ? $order['motor']['manufacturer'].' // ' : '');
                                                    if($order['motor']['instalation_side'] != null){
                                                        $concat3 .= $order['motor']['instalation_side'].' // '.$order['motor']['rail_color'].' // ';
                                                    }
                                                }
                                                if($order['motor']['frame'] != null){
                                                    $concat3 .= $order['motor']['frame'].' // ';
                                                }

                                                if($order['instalation_side'] != null){
                                                    $concat3 .= $order['instalation_side'].' // ';
                                                }

                                                if($order['motor']['drive'] != null){
                                                    $concat3 .= $order['motor']['drive'].' // ';
                                                }

                                                if($order['motor']['string_type'] != null){
                                                    $concat3 .= $order['motor']['control_color'].' ';
                                                    if($order['motor']['stringPrice'] > 0){
                                                        $concat3 .= $order['motor']['manufacturer'].' (+$'.$order['motor']['stringPrice'].') // ';
                                                    }
                                                    else{
                                                        $concat3 .= ' // ';
                                                    }
                                                    $concat3 .= $order['motor']['string_type'].' // ';
                                                }

                                                if(isset($order['motor']['height_control'])){
                                                    $concat3 .= $order['motor']['height_control'].' MTS// ';
                                                }

                                                if($order['motor']['gallery'] != null){
                                                    if($order['motor']['gallery_color'] != null){
                                                        $concat3 .= $order['motor']['gallery_color'].' // ';
                                                    }
                                                    $concat3 .= $order['motor']['gallery']['model'].' ';
                                                    if($order['motor']['galleryPrice'] > 0){
                                                        $concat3 .= '(+$'.$order['motor']['galleryPrice'].') // ';
                                                    }
                                                    else{
                                                        $concat3 .= '(+$'.$order['motor']['gallery']['price'].') // ';
                                                    }
                                                }

                                                if($order['motor']['motor'] != 0 && $order['motor']['motor'] != null){
                                                    $motorization = App\Motorization::find($order['motor']['motor']);

                                                    $concat3 .= $motorization->system.' // '.$motorization->motorizationType->name.' // '.$order['motor']['manufacturer'].' ';
                                                   if($motorization->price > 0){
                                                       $concat3 .= '(+$'.$motorization->price.') // ';
                                                   }
                                                   else{
                                                       $concat3 .= '// ';
                                                   }
                                                }

                                                if($order['motor']['control'] != null){
                                                    $concat3 .= $order['motor']['control']['description'].' ';
                                                    if($order['motor']['control']['price'] > 0){
                                                        $concat3 .= '(+$'.$order['motor']['control']['price'].') // ';
                                                    }
                                                    else{
                                                        $concat3 .= ' // ';
                                                    }
                                                }

                                                if($order['motor']['flexiballetPrice'] > 0){
                                                    $concat3 .= '(+$'.$order['motor']['flexiballetPrice'].')';
                                                }
                                            ?>
                                            <span>{{$concat3}}</span>
                                            <div style="text-transform: none;">
                                                <?php
                                                    $installmentCharge = '';
                                                    if($order['installmentCharge'] > 0){
                                                        $installmentCharge .= '// CARGO POR INSTALACIÓN: $'.$order['installmentCharge'].' MXN';
                                                    }
                                                ?>
                                                <?php
                                                    $width = $order['canvas'][0]['width'] + 0;
                                                    $height = $order['canvas'][0]['height'] + 0;
                                                    $resultWidhtXHeight = 0;
                                                    $netPrice = number_format($order['price'], 2, '.', '');
                                                    if(floatval($width) < 1 && floatval($height) < 1){
                                                        $resultWidhtXHeight = 1;
                                                    }else if(floatval($width) < 1){
                                                        $resultWidhtXHeight = number_format((floatval(1) * floatval($height)), 3, '.', '');
                                                    }elseif(floatval($height) < 1){
                                                        $resultWidhtXHeight = number_format((floatval(1) * floatval($width)), 3, '.', '');
                                                    }
                                                    else{
                                                        $resultWidhtXHeight = number_format(floatval($width) * floatval($height), 3, '.', '');
                                                    }
                                                ?>
                                                <span>Precio base (M<sup>2</sup>) ${{ $order['base_price'] }} //  M<sup>2</sup>: {{$resultWidhtXHeight}} // Precio Neto (M<sup>2</sup>): ${{$netPrice}} MXN {{$installmentCharge}} // Descuento: {{$orders['user']['discount_percent']}}% //</span>
                                                <?php
                                                    // $totaldiscount = $order['price'] - (($orders['user']['discount_percent'] / 100) * $order['price']);
                                                    $orderSum = ($order['price'] +
                                                    $order['motor']['price'] +
                                                    $order['motor']['flexiballetPrice'] +
                                                    $order['motor']['galleryPrice'] +
                                                    $order['motor']['manufacturerPrice'] +
                                                    $order['motor']['stringPrice'] +
                                                    $order['extraVertical'] +
                                                    $order['extraEnrollable']);

                                                    $totaldiscount = $orderSum - (($orders['user']['discount_percent'] / 100) * $orderSum);
                                                ?>
                                                <span>Precio neto con Descto: $@priceFormat(round($totaldiscount, 1, PHP_ROUND_HALF_UP)) MXN</span>
                                                <?php
                                                    $countSameBlinds = '';
                                                    if($order['count_same_blinds'] > 1){
                                                        $countSameBlinds = 'CANTIDAD PERSIANAS ESTE TIPO: '.$order['count_same_blinds'];
                                                    }
                                                ?>
                                                <div style="color:red">{{$countSameBlinds}}</div>
                                                <?php
                                                    $coments = $order['comment'];
                                                ?>
                                                @if ($coments != null)
                                                    <div style="color:#009688">COMENTARIOS: {{$coments}}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td style="width: 33%; background-color: white;">
                                        @if ($order['second_color'] != null)
                                            <div style="margin-left: 27px; padding-top: 20px">
                                                <div style="display: inline">
                                                    @if (File::exists('img/modelos/medium/'.$order['type'].'/'.$order['manufacturer'].'/'.$order['color']['code'].'.jpg'))
                                                        <img width="43" height="43" src="{{'img/modelos/medium/'.$order['type'].'/'.$order['manufacturer'].'/'.$order['color']['code'].'.jpg'}}">
                                                    @else
                                                        <img width="43" height="43" src="img/modelos/medium-unavailable.jpg">
                                                    @endif
                                                </div>
                                                <div style="display: inline">
                                                    @if (File::exists('img/modelos/medium/'.$order['type'].'/'.$order['manufacturer'].'/'.$order['second_color']['code'].'.jpg'))
                                                        <img width="43" height="43" src="{{'img/modelos/medium/'.$order['type'].'/'.$order['manufacturer'].'/'.$order['second_color']['code'].'.jpg'}}">
                                                    @else
                                                        <img width="43" height="43" src="img/modelos/medium-unavailable.jpg">
                                                    @endif
                                                </div>
                                            </div>
                                        @else
                                            <div style="margin-left: 76px; padding-top: 20px">
                                                <div style="display: inline">
                                                    @if (File::exists('img/modelos/medium/'.$order['type'].'/'.$order['manufacturer'].'/'.$order['color']['code'].'.jpg'))
                                                        <img width="43" height="43" src="{{'img/modelos/medium/'.$order['type'].'/'.$order['manufacturer'].'/'.$order['color']['code'].'.jpg'}}">
                                                    @else
                                                        <img width="43" height="43" src="img/modelos/medium-unavailable.jpg">
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                        <div style="font-weight: bolder; background-color:#f1f1f2; font-size: 9.57px; text-align: right; padding-bottom: 4px; padding-top: 3px; padding-right: 4px">
                                            <span>TOTAL: </span>
                                            <span style="color: #47a5ad">
                                                <?php
                                                    // $unitaryPrice = ($order['count_same_blinds'] <= 0 ? 1 : $order['count_same_blinds']) * ($totaldiscount +
                                                    // $order['motor']['price'] +
                                                    // $order['motor']['flexiballetPrice'] +
                                                    // $order['motor']['galleryPrice'] +
                                                    // $order['motor']['manufacturerPrice'] +
                                                    // $order['motor']['stringPrice'] +
                                                    // $order['extraVertical'] +
                                                    // $order['extraEnrollable'] +
                                                    // $order['installmentCharge']);
                                                    // $total += $unitaryPrice ;
                                                    $unitaryPrice = ($order['count_same_blinds'] <= 0 ? 1 : $order['count_same_blinds']) * ($totaldiscount + $order['installmentCharge']);
                                                    $total += $unitaryPrice ;
                                                ?>
                                                $@priceFormat(round($unitaryPrice, 1, PHP_ROUND_HALF_UP)) MXN
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                @endforeach
                @if (($i+1) == (round(count($orders['orders'])/2)))
                    <td style="height: 99px; border: 1px dashed black; width: 393px;">
                    </td>
                @endif
            @endif
        </tr>
    @endfor

    </table>

    <div style="page-break-inside: avoid;">
        <div style="margin-top: 14px; margin-left: 500px">
            <table style="margin-right: 17px; min-width: 275px; border-collapse: collapse; border:1px solid black;">
                <tr style="border:1px solid black;font-weight: bolder;">
                    <td style="font-size: 9px; text-align: center;">
                        SUBTOTAL
                    </td>
                    <td style="font-size: 12px; text-align: right; padding-right: 11px;">
                        $@priceFormat(round($total, 1, PHP_ROUND_HALF_UP)) MXN
                    </td>
                </tr>
                <tr style="border: 1px solid black;font-weight: bolder;">
                    <td style="font-size: 9px; text-align: center;">
                        IVA
                    </td>
                    <td style="font-size: 12px; text-align: right; padding-right: 11px;">
                        INCLUIDO
                    </td>
                </tr>
                <tr style="border: 1px solid black;font-weight: bolder; font-size: 16px; background-color:#418686; color: white;">
                    <td style="text-align: center; padding-top: 3px; padding-bottom: 3px;">
                        <div>TOTAL</div>
                        <div style="font-size: 7px;">Pago con SPEI (Transferencia bancaria)</div>
                    </td>
                    <td style="text-align: right; padding-right: 11px; padding-top: 3px; padding-bottom: 3px;">
                        <div>$@priceFormat(round($total, 1, PHP_ROUND_HALF_UP)) MXN</div>
                    </td>
                </tr>
                <tr style="border: 1px solid black;font-weight: bolder; background-color:#E0E0E0;">
                    <td style="font-size: 7px; text-align: center; padding-top: 3px; padding-bottom: 3px;">
                        <div>Pago con tarjeta 1 sola emisión.</div>

                    </td>
                    <td style="font-size: 12px; text-align: right; padding-right: 11px; padding-top: 3px; padding-bottom: 3px;">
                        $@priceFormat(round($total*1.05, 1, PHP_ROUND_HALF_UP)) MXN
                    </td>
                </tr>
                <tr style="border: 1px solid black;font-weight: bolder; background-color:#E0E0E0;">
                    <td style="font-size: 7px; text-align: center; padding-top: 3px; padding-bottom: 3px;">
                        <div>Pago a 6 meses.</div>

                    </td>
                    <td style="font-size: 12px; text-align: right; padding-right: 11px; padding-top: 3px; padding-bottom: 3px;">
                        <div>$@priceFormat(round($total*1.15, 1, PHP_ROUND_HALF_UP)) MXN</div>
                        <div style="font-size: 7px;">6 pagos de $@priceFormat(round((($total*1.15) / 6), 1, PHP_ROUND_HALF_UP)) MXN</div>
                    </td>
                </tr>
            </table>
        </div>
        <div style="margin-bottom: 5px; margin-top: 19px;">
            <hr style="width:27%; text-align:left; margin-left:auto; margin-right: auto; border: 1px solid #47a5ad;">
        </div>
        <div style="width: 87%; margin: auto; font-size: 8px; line-height: 10px; text-align: center;">
            <!-- <div>

                <strong>Deposito a la cuenta de Banorte: 0892608267 // CLABE: 072 470 0089 2608 2678 // A nombre de Materiales Decorativos S. de R.L, M</strong>

            </div> -->
            <i>
                Favor de revisar importes y cantidades descritas en este documento // Cualquier variación será motivo de otra cotización // La fecha del pedido se toma en cuenta a partir de la fecha de pago
                No se procesan pedidos que no estén pagados // La mercancía viaja por cuenta y riesgo del comprador // Los tonos de las telas pueden variar ligeramente a los del muestrario
                Para precios en dólares se tomará en cuenta tipo de cambio emitido por Banorte el día del pago. // No hay cambios ni devoluciones una vez cortada la tela. Precios sujetos a cambios sin previo aviso.
            </i>

        </div>
    </div>
</body>
</html>
