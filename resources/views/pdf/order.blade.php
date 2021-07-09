<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title></title>
    <style>
        @font-face {
            font-family: 'Montserrat Black';
            src: url('/fonts/Montserrat-Black.ttf') format('truetype');
            font-weight: bold;
            font-style: normal;
        }

        @font-face {
            font-family: 'Montserrat Bold';
            src: url('/fonts/Montserrat-Bold.ttf') format('truetype');
            font-weight: bold;
            font-style: normal;
        }
        @font-face {
            font-family: 'Montserrat';
            src: url('https://fonts.googleapis.com/css2?family=Montserrat') format('truetype');
            font-weight: normal;
            font-style: normal;
        }
        body{
            font-family: 'Montserrat';
        }
        .row{
            display: flex;
            flex-wrap: wrap;
            flex: 1 1 auto;
            margin: -12px;
        }
        .col-md-4{
            flex: 0 0 33.3333333333%;
            max-width: 33.3333333333%;
        }
        .d-block{
            display: block;
        }
        .justify-space-around{
            justify-content: space-around!important;
        }
        
    </style>
</head>
<body>

    <!-- <div class="row justify-space-around" style="height: 100px; width: 100%">
        <div class="col-md-4" style="margin: auto">
            <img width="80%" src="img/logos/rollux.png" >
        </div>
        <div class="col-md-4" style="border-left: solid #47a5ad 4px;">
            <div style="margin-left: 12px;margin-top: 20px; margin-botom: 6px;">
                <div class="d-block" style="font-weight: bolder;font-size: 12px;" >Rollux | Atención a Distribuidores</div>
                <div class="d-block" style="font-size: 12px;">Whatsapp: 55 4894 8279</div>
                <div class="d-block" style="font-size: 12px;">Correo:  ventas@rolllux.com.mx</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="d-block" style="font-weight: bolder; font-size: 1.2em;">
                Cotización en línea
            </div>
            <div class="d-block">
                Fecha: 30/06/2021
            </div>
        </div>
    </div>        -->
    <table style="border-collapse:collapse; width: 100%;">
        <tbody >
            <tr>
                <td style="width: 33.3333%">
                    <img width="250px" src="img/logos/rollux.png" >
                </td>
                <td style="border-left: solid #47a5ad 4px;width: 33.3333%">
                    <div class="d-block" style="padding-left: 15px; font-weight: bolder;font-size: 12px;" >Rollux | Atención a Distribuidores</div>
                    <div class="d-block" style="padding-left: 15px; font-size: 12px;">Whatsapp: 55 4894 8279</div>
                    <div class="d-block" style="padding-left: 15px; font-size: 12px;">Correo:  ventas@rolllux.com.mx</div>
                </td>
                <td style="text-align: center; width: 33.3333%">
                    <div class="d-block" style="font-weight: bolder; font-size: 1.2em;">
                        Cotización en línea
                    </div>
                    <div class="d-block">
                        Fecha: 30/06/2021
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>
