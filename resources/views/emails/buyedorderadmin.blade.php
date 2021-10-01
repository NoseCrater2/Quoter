@component('mail::message')
Numero de orden: {{ $order->user->id.'PT'.Carbon\Carbon::parse($order->created_at)->format('dmy').$order->id }}<br>
{{ $order->user->name.' '.$order->user->last_name }} ha realizado una orden y está esperando la revisión y confirmación de su pago.
@endcomponent

