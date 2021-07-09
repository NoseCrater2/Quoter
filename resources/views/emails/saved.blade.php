@component('mail::message')
Hola {{ $user->name }} <br>
Ya puedes acceder a Rollux
Con el correo: {{$user->email}} <br>
Y la contraseña: {{$user->password}} <br>
Se te asignó un descuento del {{$user->discount_percent}}% en todos tus pedidos.


@endcomponent