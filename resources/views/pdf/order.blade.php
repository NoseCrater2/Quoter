<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
  
</head>
<body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>

<nav  style="background-color: #47a5ad; display: block;">
    <a  href="#">
        <img src="{{ public_path('img/white-logo.png') }}" width="200" height="75" alt="logo" style="margin: 5px">
    </a>
    <h1>COTIZACIÓN</h1>
</nav>
    @foreach($orders as $order)
        <table style="font-family: Arial, Helvetica, sans-serif; font-size: 0.8em; width: 100%;">
            <tbody> 
              
                <tr >
                
                    <td colspan="4">Tipo</td>
                    <td  colspan="5">{{ $order['type'] }}</td>
                    <td colspan="1" rowspan="7">
                        <img src="{{ public_path('img/modelos/medium/'.$order['code'].'.jpg') }}" width="150" height="150" alt="color" style="margin-top: 15px; align-self: end;" >
                    </td>
                </tr>

                <tr >
                    <td colspan="4">Modelo</td>
                    <td colspan="5">{{ $order['variant'] }}</td>
                </tr>

                <tr >
                    <td colspan="4">Color</td>
                    <td colspan="5">{{ $order['color'] }} | {{ $order['code'] }} </td>
                </tr>
                <tr >
                    <td colspan="4">Ancho</td>
                    <td colspan="5">{{ $order['width'] }}MT</td>
                </tr>
                <tr >
                    <td colspan="4">Alto</td>
                    <td colspan="5">{{ $order['height'] }}MT</td>
                </tr>
                <tr >
                    <td colspan="4">Precio</td>
                    <td colspan="5">{{ $order['price'] }}</td>
                </tr>

                <tr >
               
                    <td colspan="4">Control</td>
                    <td colspan="5" >{{ $order['control'] }}</td>
                    
                </tr>
               
             
            </tbody>
          
        </table>
        
        <hr style="background-color: #47a5ad">
        @endforeach
      
       
</body>
</html>