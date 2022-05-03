<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" href="{{ asset('css/app.css') }}">     -->
    <title>Reporte Semanal de Casas de Paz</title>
    <style>
        body {
            margin: -30px;
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
            background-color: #fff;
            color: #000;
        }
        #table tbody tr:nth-child(even) {
            background: #d4d4d4;
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
    </style>
</head>
<body> 
    @foreach($datos as $keyFor=>$dato)
    <p style="font-family: 'Inter', sans-serif; font-size: 12x; font-weight: bold; text-align: center;"><u>REPORTE DE CASA DE PAZ</u></p>
    <div id="left">
        <!-- PRIMERA PARTE -->
        <div>
            <div id="left">
                <p style="font-family: 'Inter', sans-serif; font-size: 11px; font-weight: bold; margin: 0; color: #000;">CDP N°:
                    <span style="font-family: 'Inter', sans-serif;">{{ $dato['cdp'] }}</span>
                </p>
            </div>          
            <div id="right">
                <p style="font-family: 'Inter', sans-serif; font-size: 11px; font-weight: bold; margin: 0; color: #000;">FECHA:
                    <span style="font-family: 'Inter', sans-serif;">__/__/____</span>
                </p>
            </div>            
        </div>
        
        <div>
            <p style="font-family: 'Inter', sans-serif; font-size: 12px; font-weight: bold; margin: 0; color: #000;"><u>NOMBRES DEL LIDERAZGO</u></p>
        </div>               
        <span style="font-family: 'Inter', sans-serif; font-size: 11px; font-weight: bold; margin: 0; color: blue; color: #002138;">
        &nbsp;&nbsp;ENCARGADO: {{ $liderred->ApeCon.' '.$liderred->NomCon }}
        </span><br/>
        <span style="font-family: 'Inter', sans-serif; font-size: 11px; font-weight: bold; margin: 0; color: blue; color: #002138;">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;LÍDER: {{ $dato['lider'] }}
        </span><br/>
        <span style="font-family: 'Inter', sans-serif; font-size: 11px; font-weight: bold; margin: 0; color: blue; color: #002138;">
        SUBLÍDER(ES): _____________________________________________
        </span>
        <!-- PRIMERA PARTE FIN -->

    </div>    
    <div id="right">
        <div>
            <p style="font-family: 'Inter', sans-serif; font-size: 11px; font-weight: bold; margin: 0; color: #000;">
                <span style="font-family: 'Inter', sans-serif;">{{ $red }}</span>
            </p>
        </div>
        
        <div>
            <p style="font-family: 'Inter', sans-serif; font-size: 12px; font-weight: bold; margin: 0; color: #000;"><u>DATOS DE LA REUNIÓN</u></p>
        </div>               
        <span style="font-family: 'Inter', sans-serif; font-size: 11px; font-weight: bold; margin: 0; color: blue; color: #002138;">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;TEMA: _____________________________________________
        </span><br>
        <span style="font-family: 'Inter', sans-serif; font-size: 11px; font-weight: bold; margin: 0; color: blue; color: #002138;">
            OFRENDA: S/. ______._______
        </span><br>        
        <br/><br/><br/>
    </div>    
    <div>
        <u style="font-family: 'Inter', sans-serif; font-size: 12px; font-weight: bold; text-decoration: none;">MIEMBROS DE LA CASA DE PAZ</u>
        <div style="margin-top: 10px;">
            <table id="table">
                <thead>
                    <tr style="border: 1px solid;">
                        <th style="width: 5%"></th>
                        <th style="width: 30%"></th>
                        <th colspan="2" style="width: 14%; background-color: #e0e02b">ASISTENCIAS</th>
                        <th style="width: 8%"></th>
                        <th style="width: 40%"></th>
                    </tr>                    
                    <tr>
                        <th style="width: 5%; background-color: #c7c71e">N°</th>
                        <th style="width: 30%; font-size: 10px; background-color: #c7c71e">NOMBRES Y APELLIDOS</th>
                        <th style="width: 6%; font-size: 10px; background-color: #c7c71e">CULTO</th>
                        <th style="width: 6%; font-size: 10px; background-color: #c7c71e">CDP</th>
                        <th style="width: 13%; font-size: 10px; background-color: #c7c71e">TIPO</th>
                        <th style="width: 40%; font-size: 10px; background-color: #c7c71e">OBSERVACIÓN Y/O MOTIVO DE FALTA</th>
                    </tr>                    
                </thead>
                <tbody>                     
                    @foreach($dato['miembros'] as $key=>$miembro)
                        <tr>
                            <td class="td">{{ $key+1 }}</td>
                            <td class="td" style="text-align: left !important; padding-left: 10px;">
                                {{ substr($miembro['miembro']->ApeCon.' '.$miembro['miembro']->NomCon, 0, 34) }}
                            </td>                                                        
                            @if($miembro['asistencias'] == 'PERMISO')
                                <td class="td" style="color: #3a73a6">PERMISO</td>
                            @endif
                            @if($miembro['asistencias'] == 'ASISTIO')
                                <td class="td">ASISTIÓ</td>
                            @endif
                            @if($miembro['asistencias'] == 'FALTO')
                                <td class="td" style="color: #de214a">FALTÓ</td>
                            @endif
                            <td class="td"></td>
                            <td class="td">{{ $miembro['miembro']->TipCon }}</td>
                            <td class="td"></td>
                        </tr>              
                    @endforeach
                </tbody>
            </table>            
        </div>
    </div>
    <div style="page-break-after:always;"></div>
    @endforeach
</body>
