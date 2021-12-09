@component('mail::message')
Buen día {{ $order->user->name.' '.$order->user->last_name }}.<br>
Su orden, identificada como #ORDEN {{ $order->user->id.'P'.Carbon\Carbon::parse($order->created_at)->format('dmy').$order->id }} ha sido adquirida mediante NETPAY.<br>
Haga clic en el botón para ver su orden.
@component('mail::button', ['url' => 'https://www.rollux.com.mx/dashboard/lists/ordenes/?activeorder='.urlencode($order->id), 'color' => 'success'])
Ver orden
@endcomponent
@endcomponent
