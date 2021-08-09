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


@component('mail::button', ['url' => 'https://www.rollux.com.mx/dashboard/users/?name='.urlencode($user->name).'&last_name='.urlencode($user->last_name).'&email='.urlencode($user->email).'&phone='.urlencode($user->phone).'&company='.urlencode($user->company).'&address='.urlencode($user->address).'&city='.urlencode($user->city).'&state='.urlencode($user->state).'&zip_code='.urlencode($user->zip_code), 'color' => 'success'])
Agregar usuario al sistema
@endcomponent

@endcomponent
