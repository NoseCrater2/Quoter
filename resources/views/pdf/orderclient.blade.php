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

        $date = new Carbon\Carbon;
        $total = 0;
        setlocale(LC_MONETARY, 'es_MX');
        $countBlinds = 1;
        // $blindVariant1 = App\Variant::find(4137);
    ?>
    <table style="border-collapse:collapse; width: 100%; margin-top: -12px">
        <tbody>
            <tr>
                <td style="width: 20%; padding-left: 9px; height: 126px;">
                    <img width="238px" src="img/logos/rollux.png" >
                </td>
                <td style="width: 40%;">
                    <div style="border-left: solid #47a5ad 4px; padding-top: 12px; padding-bottom: 12px;">
                        <div style="padding-left: 13px; padding-top: 15px">
                            <div class="d-block" style="font-weight: bolder; font-size: 16px;">Rollux | Atención a Distribuidores</div>
                            <div class="d-block" style="font-size: 16px;">Whatsapp: 55 4894 8279</div>
                            <div class="d-block" style="font-size: 16px;">Correo:  ventas@rolllux.com.mx</div>
                        </div>
                    </div>
                </td>
                <td style="text-align: center; width: 40%; padding-right: 15px; padding-left: 7px; padding-top: 11px">
                    <div style="padding-top: 3px; margin-right: 7px;">
                        <div class="d-block" style="font-weight: bolder; font-size: 22px;" >Cotización en línea</div>
                        <div class="d-block" style="font-size: 12px;">Fecha: {!! $date->now()->format('d/m/Y'); !!}</div>
                        <div class="d-block" style="font-size: 12px;">Valida hasta: {!! $date->addDays(8)->format('d/m/Y'); !!}</div>
                    </div>
                </td>
            </tr>
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
    @for($i = 0; $i < (round(count($orders)/2)); $i++)
        <tr style="width: 100%;">
            @if (count($orders)%2 == 0)
                @foreach (@returnedOneTwoOrders(($i + 1), $orders) as $key => $order)
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
                                                    $concat3 .= $order['celular_type'].' // '.$order['celular_drive'].' // ';
                                                }
                                                if($order['motor']['selected_panel'] != null){
                                                    $concat3 .= $order['motor']['selected_panel'].' // PANELES: '.$order['motor']['panels'].' // ';
                                                }
                                                if($order['motor_type'] != null){
                                                    $concat3 .= $order['motor_type'].' // '.$order['motor']['side_control'].' // '.$order['motor']['manufacturer'].' // ';
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
                                            <?php
                                                    $countSameBlinds = '';
                                                    if($order['count_same_blinds'] > 1){
                                                        $countSameBlinds = 'CANTIDAD PERSIANAS ESTE TIPO: '.$order['count_same_blinds'];
                                                    }
                                            ?>
                                            <div style="color:red">{{$countSameBlinds}}</div>
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
                                                    $unitaryPrice = ($order['count_same_blinds'] <= 0 ? 1 : $order['count_same_blinds']) * ($order['price'] +
                                                    $order['motor']['price'] +
                                                    $order['motor']['flexiballetPrice'] +
                                                    $order['motor']['galleryPrice'] +
                                                    $order['motor']['manufacturerPrice'] +
                                                    $order['motor']['stringPrice'] +
                                                    $order['extraVertical'] +
                                                    $order['extraEnrollable']);
                                                    $total += $unitaryPrice;
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
                @foreach (@returnedOneTwoOrders(($i + 1), $orders) as $key => $order)
                    <td style="height: 99px; border: 1px dashed black; width: 393px;">
                        <table style="font-size: 6px; border: 1px solid #d1d3d4; background-color: #f1f1f2; margin-left: 8px; margin-right: 8px;">
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
                                                    $concat3 .= $order['celular_type'].'// '.$order['celular_drive'].' // ';
                                                }
                                                if($order['motor']['selected_panel'] != null){
                                                    $concat3 .= $order['motor']['selected_panel'].' // PANELES: '.$order['motor']['panels'].' // ';
                                                }
                                                if($order['motor_type'] != null){
                                                    $concat3 .= $order['motor_type'].' // '.$order['motor']['side_control'].' // '.$order['motor']['manufacturer'].' // ';
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
                                            <?php
                                                    $countSameBlinds = '';
                                                    if($order['count_same_blinds'] > 1){
                                                        $countSameBlinds = 'CANTIDAD PERSIANAS ESTE TIPO: '.$order['count_same_blinds'];
                                                    }
                                            ?>
                                            <div style="color:red">{{$countSameBlinds}}</div>
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
                                                    $unitaryPrice = ($order['count_same_blinds'] <= 0 ? 1 : $order['count_same_blinds']) * ($order['price'] +
                                                    $order['motor']['price'] +
                                                    $order['motor']['flexiballetPrice'] +
                                                    $order['motor']['galleryPrice'] +
                                                    $order['motor']['manufacturerPrice'] +
                                                    $order['motor']['stringPrice'] +
                                                    $order['extraVertical'] +
                                                    $order['extraEnrollable']);
                                                    $total += $unitaryPrice;
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
                @if (($i+1) == (round(count($orders)/2)))
                    <td style="height: 99px; border: 1px dashed black; width: 393px;">
                    </td>
                @endif
            @endif
        </tr>
    @endfor

    </table>

    <div style="page-break-inside: avoid;">
        <div style="margin-top: 17px; margin-left: 500px">
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
                        TOTAL
                    </td>
                    <td style="text-align: right; padding-right: 11px; padding-top: 3px; padding-bottom: 3px;">
                        $@priceFormat(round($total, 1, PHP_ROUND_HALF_UP)) MXN
                    </td>
                </tr>
            </table>
        </div>
        <div style="margin-bottom: 5px; margin-top: 27px;">
            <hr style="width:27%; text-align:left; margin-left:auto; margin-right: auto; border: 1px solid #47a5ad;">
        </div>
        <div style="width: 87%; margin: auto; font-size: 8px; line-height: 10px; text-align: center;">
            <i>
                Favor de revisar importes y cantidades descritas en este documento // Cualquier variación será motivo de otra cotización // La fecha del pedido se toma en cuenta a partir de la fecha de pago
                No se procesan pedidos que no estén pagados // La mercancía viaja por cuenta y riesgo del comprador // Los tonos de las telas pueden variar ligeramente a los del muestrario
                Para precios en dólares se tomará en cuenta tipo de cambio emitido por Banorte el día del pago. // No hay cambios ni devoluciones una vez cortada la tela. Precios sujetos a cambios sin previo aviso.
            </i>
        </div>
    </div>
</body>
</html>

