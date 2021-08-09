@component('mail::message')
<!-- <img style="width:400px; height: 153px;" src="{{asset('/img/logo.png')}}"/><br> -->
Hola {{ $user->name }} <br>
Recibimos tu petición para añadirte como interiorista en Rollux México.
Revisaremos la información y posteriormente te enviaremos un nuevo email con tu contraseña de acceso.
A continuación se muestra la información que nos hiciste legar:
@component('mail::table')
| Campo         | Información         |
| ------------- |---------------------------------------:|
| Nombre        | {{ $user->name }} {{$user->last_name}} |
| Email         | {{ $user->email }}                     |
| Telefono      | {{ $user->phone }}                     |
| Empresa       | {{ $user->company }}                   |                            |
| Dirección     | {{ $user->address }}                   |
| Ciudad        | {{ $user->city }}                      |
| Estado        | {{ $user->state }}                     |
| Código Postal | {{ $user->zip_code }}                  |
| Mensaje       | {{ $user->comments }}                  |
@endcomponent


@endcomponent
