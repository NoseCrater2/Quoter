@component('mail::message')
Un interiorista se ha registrado en el sistema, sus datos aparecen a continuación:
@component('mail::table')
| Campo         | Información         |
| ------------- |:--------------------------------------:|
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


@component('mail::button', ['url' => 'http://127.0.0.1:8000/dashboard/users/?name='.$user->name.'&last_name='.$user->last_name.'&email='.$user->email.'&phone='.$user->phone.'&company='.$user->company.'&address='.$user->address.'&city='.$user->city.'&state='.$user->state.'&zip_code='.$user->zip_code, 'color' => 'success'])
Agregar usuario al sistema
@endcomponent

@endcomponent