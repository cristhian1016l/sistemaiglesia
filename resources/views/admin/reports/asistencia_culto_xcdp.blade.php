<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" href="{{ asset('css/app.css') }}">     -->
    <title>Reporte Asistencias cultos por casas de paz</title>
    <style>
        body {
            margin: 0;
            font-family: "Nunito", sans-serif;
            font-size: 0.9rem;
            font-weight: 400;
            line-height: 1.6;
            color: #212529;
            text-align: left;
            background-color: #fff;
        }        
        @font-face {
            font-family: 'Inter';
            font-style: normal;
            font-weight: 600;
            src: local('Inter Bold'), local('Inter-Bold'), url(https://fonts.googleapis.com/css2?family=Inter:wght@600&display=swap) format('truetype');
        }   
        #table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            /* width: 100%; */
            /* margin: 0 auto; */
            width: 100%;  /* Este será el ancho que tendrá tu columna */
            /* background-color: #CCCCCC;  Aquí pon el color del fondo que quieras para este lateral */
            float:left; /* Aquí determinas de lado quieres quede esta "columna" */
        }        

        #table td, #table th {
            
            padding: 0.5px;
        }

        
        #table th {
            font-family: 'Inter', sans-serif;
            font-size: 12px; 
            text-align: center; 
            padding: 0.5px;            
            /* background-color: #000;
            color: white; */
        }
        .td{
            font-family: 'Inter', sans-serif; 
            font-size: 10px; 
            text-align: center; 
            padding: 0.5px;
            border: 1px solid #d2d2d2;
        }

        #data {
            width: 30%;  /* Este será el ancho que tendrá tu columna */
            /* background-color: #CCCCCC;  Aquí pon el color del fondo que quieras para este lateral */
            float:right; /* Aquí determinas de lado quieres quede esta "columna" */
        }        

        #right {
            width: 50%;  /* Este será el ancho que tendrá tu columna */
            /* background-color: #CCCCCC;  Aquí pon el color del fondo que quieras para este lateral */
            float:right; /* Aquí determinas de lado quieres quede esta "columna" */
        }

        #left {
            width: 50%;
            float: left;
            background-color: #FFFFFF;
            /* border:#000000 1px solid; ponemos un donde para que se vea bonito */
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <!-- <img src="{{ asset('dist/img/logo.png') }}" alt="Logo" width="50" height="50" align="right"> -->        
    <div>
        <!-- <u style="font-family: 'Inter', sans-serif; font-size: 12px; font-weight: bold;">REGISTRO DE ASISTENCIA</u>         -->
        <!-- <p style="font-family: 'Inter', sans-serif; font-size: 12x; font-weight: bold; text-align: center;">REGISTRO DE MIEMBROS DE CASAS DE PAZ POR RED</p>     -->
        <div style="margin-top: 10px;">
            <!-- <hr style="border-top: 1px trashed;"> -->
            @foreach($redes as $red)
            <table id="table">
                <tbody>                    
                    <?php
                        $meses = [ 1 => 'ENERO', 2 => 'FEBRERO', 3 => 'MARZO', 4 => 'ABRIL', 5=> 'MAYO', 6 => 'JUNIO', 7 => 'JULIO', 8 => 'AGOSTO', 9 => 'SETIEMBRE', 10 => 'OCTUBRE', 11 => 'NOVIEMBRE', 12 => 'DICIEMBRE'];
                        $dias = [ 1 => 'LUNES', 2 => 'MARTES', 3 => 'MIÉRCOLES', 4 => 'JUEVES', 5=> 'VIERNES', 6 => 'SÁBADO', 7 => 'DOMINGO'];
                        $mes = $meses[date('n', strtotime($red['fecha']))];
                        $dia = $dias[date('N', strtotime($red['fecha']))];
                        $dia_numero = date('d', strtotime($red['fecha']));
                        $anio = date('Y', strtotime($red['fecha']));
                    ?>
                    <tr>
                        @switch($red['id_red'])
                            @case(1)
                                <td colspan="3" class="td" style="font-size: 16px; font-weight: bold; background-color: #2DC7FF;">{{ $red['nombre_red'] }}</td>
                                @break
                            @case(2)
                                <td colspan="3" class="td" style="font-size: 16px; font-weight: bold; background-color: #731963; color: white;">{{ $red['nombre_red'] }}</td>
                                @break
                            @case(4)
                                <td colspan="3" class="td" style="font-size: 16px; font-weight: bold; background-color: #C1292E; color: white;">{{ $red['nombre_red'] }}</td>
                                @break
                            @case(5)
                                <td colspan="3" class="td" style="font-size: 16px; font-weight: bold; background-color: #275DAD; color: white;">{{ $red['nombre_red'] }}</td>
                                @break
                            @default
                                <td colspan="3" class="td" style="font-size: 16px; font-weight: bold">{{ $red['nombre_red'] }}</td>
                        @endswitch                        
                    </tr>                    
                    <tr style="background-color: #275DAD; color: white;">
                        <td class="td" rowspan="2" style="font-size: 13px; font-weight: bold; width: 5%">N°</td>
                        <td class="td" rowspan="2" style="font-size: 13px; font-weight: bold; width: 6%">N° CDP</td>
                        <td class="td" rowspan="2" style="font-size: 13px; font-weight: bold; width: 35%">DIRECCIÓN</td>
                        <td class="td" rowspan="2" style="font-size: 13px; font-weight: bold; width: 24%;">NOMBRE DEL LIDER</td>
                        <td class="td" colspan="4" style="font-size: 13px; font-weight: bold; width: 30%;">SERVICIO {{ $dia.' '.$dia_numero .' DE '.$mes.' DEL '.$anio }}</td>
                    </tr>
                    <tr style="background-color: #275DAD; color: white;">
                        <td class="td" style="font-size: 10px; font-weight: bold;">TOT. MIEM</td>
                        <td class="td" style="font-size: 10px; font-weight: bold;">ASISTENCIA</td>
                        <td class="td" style="font-size: 10px; font-weight: bold;">FALTAS</td>
                        <td class="td" style="font-size: 10px; font-weight: bold;">PERMISOS</td>
                    </tr>
                    <?php $i = 1; ?>
                    @foreach($detalles as $detalle)                                      
                        @if($red['id_red'] == $detalle['id_red'])                                                
                            @if($detalle['faltas'] > 0.5*$detalle['total_miembros'])
                            <tr style="background-color: red; color: #fff;">
                            @else
                            <tr>
                            @endif                            
                                <td class="td" style="padding: 2.5px;">{{ $i }}</td>
                                <td class="td" style="padding: 2.5px;">{{ $detalle['cdp'] }}</td>
                                <td class="td" style="padding: 2.5px; text-align: left">{{ $detalle['direccion'] }}</td>                            
                                <td class="td" style="padding: 2.5px; text-align: left">{{ $detalle['lider'] }}</td>
                                <td class="td" style="font-weight: bold; padding: 2.5px;">{{ $detalle['total_miembros'] }}</td>
                                <td class="td" style="font-weight: bold; padding: 2.5px;">{{ $detalle['asistencias'] }}</td>
                                <td class="td" style="font-weight: bold; padding: 2.5px;">{{ $detalle['faltas'] }}</td>
                                <td class="td" style="font-weight: bold; padding: 2.5px;">{{ $detalle['permisos'] }}</td>
                            </tr> 
                            <?php $i++; ?>
                        @endif
                    @endforeach
                    <tr>
                        <td class="td" colspan="4"></td>
                        <td class="td" style="font-size: 12px; font-weight: bold; background-color: #44AF69; color: white;">{{ $red['total_miembros_red'] }}</td>
                        <td class="td" style="font-size: 12px; font-weight: bold; background-color: #44AF69; color: white;">{{ $red['total_miembros_asistencias'] }}</td>
                        <td class="td" style="font-size: 12px; font-weight: bold; background-color: #44AF69; color: white;">{{ $red['total_miembros_faltas'] }}</td>
                        <td class="td" style="font-size: 12px; font-weight: bold; background-color: #44AF69; color: white;">{{ $red['total_miembros_permisos'] }}</td>
                    </tr>                    
                </tbody>
            </table>
            <br>
            <h4>- Si el 50% de los miembros de una casa de paz faltaron, la fila se mostrará de un color diferente</h4>
            <div style="page-break-after:always;"></div>                    
            @endforeach
        </div>
</body>
