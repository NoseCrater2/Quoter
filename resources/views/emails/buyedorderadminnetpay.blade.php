@component('mail::message')
Numero de orden: {{ $order->user->id.'P'.Carbon\Carbon::parse($order->created_at)->format('dmy').$order->id }}<br>
{{ $order->user->name.' '.$order->user->last_name }} ha adquirido esta orden mediante NETPAY. <br>
Haga clic en el botón para ver la orden.
@component('mail::button', ['url' => 'https://www.rollux.com.mx/dashboard/lists/ordenes-admin/?activeorder='.urlencode($order->id), 'color' => 'success'])
Ver orden
@endcomponent
@endcomponent

