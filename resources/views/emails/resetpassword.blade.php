@component('mail::message')
Hola {{ $user->name }} <br> tu nueva contraseña es <strong>{{ $user->password }}</strong>.
<br>
Puedes usar esta contraseña para acceder a tu cuenta en Rollux

@endcomponent