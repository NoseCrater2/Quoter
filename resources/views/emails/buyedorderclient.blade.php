@component('mail::message')
Buen día {{ $order->user->name.' '.$order->user->last_name }}.<br>
Su orden, identificada como #ORDEN {{ $order->user->id.'PT'.Carbon\Carbon::parse($order->created_at)->format('dmy').$order->id }} ya casi es suya.<br>
Le dejamos los datos de su orden, así como la información de cuenta para que proceda con su pago.<br>
<table style="border: 1px solid black; border-collapse: collapse; width: 100%">
    <tbody>
        <tr>
            <td style="border: 1px solid black;">#ORDEN POR PAGAR</td>
            <td style="border: 1px solid black;">#CUENTA DE BANCO</td>
            <td style="border: 1px solid black;">CLABE INTERBANCARIA</td>
        </tr>
        <tr>
            <td style="border: 1px solid black;">{{ $order->user->id.'PT'.Carbon\Carbon::parse($order->created_at)->format('dmy').$order->id }}</td>
            <td style="border: 1px solid black;">0892 6082 67</td>
            <td style="border: 1px solid black;">072 470 0089 2608 2678</td>
        </tr>
    </tbody>
</table>
<div>A NOMBRE DE: MATERIALES DECORATIVOS S. DE R.L. MI.</div><br>
Una vez realizado su pago, le pedimos de favor espere confirmación del personal administrativo para validar su pago.<br>
Gracias.
@component('mail::button', ['url' => 'https://www.rollux.com.mx/dashboard/lists/ordenes/?activeorder='.urlencode($order->id), 'color' => 'success'])
Ver orden
@endcomponent
@endcomponent
