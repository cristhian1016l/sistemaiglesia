<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" href="{{ asset('css/app.css') }}">     -->
    <title>Reporte Discipulado</title>
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
            width: 70%;  /* Este será el ancho que tendrá tu columna */
            /* background-color: #CCCCCC;  Aquí pon el color del fondo que quieras para este lateral */
            float:left; /* Aquí determinas de lado quieres quede esta "columna" */
        }        

        #table td, #table th {
            border: 1px solid #ddd;
            padding: 0.5px;
        }

        #table tr:nth-child(even){background-color: #f2f2f2;}
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
    <!-- <img src="{{ asset('dist/img/logo.png') }}" alt="Logo" width="50" height="50" align="right"> -->
    <p style="font-family: 'Inter', sans-serif; font-size: 13x; font-weight: bold; text-align: center;">REPORTE DE CASA DE PAZ</p>    
    <div id="left">
        <u style="font-family: 'Inter', sans-serif; font-size: 12px; font-weight: bold;">DATOS DEL MENTOR(A)</u>
        <div>
            <div>
                <p style="font-family: 'Inter', sans-serif; font-size: 11px; font-weight: bold; margin: 0; color: #000;">MENTOR: 
                    <span style="font-family: 'Inter', sans-serif; font-size: 11px; margin: 0; color: blue; color: #002138;">{{ $asis[0]->EncArea }}</span>
                </p>
            </div>            
            <div>
                <p style="font-family: 'Inter', sans-serif; font-size: 11px; font-weight: bold; margin: 0; color: #000;">DESCRICIÓN: 
                    <span style="font-family: 'Inter', sans-serif; font-size: 11px; margin: 0; color: blue; color: #002138;">{{ $asis[0]->DesArea }}</span>
                </p>
            </div>
        </div>
    </div>    
    <div id="right">
        <u style="font-family: 'Inter', sans-serif; font-size: 12px; font-weight: bold;">TEMA Y OFRENDA</u>
        <div>
            <div>
                <p style="font-family: 'Inter', sans-serif; font-size: 11px; font-weight: bold; margin: 0; color: #000;">TEMA DE ENSEÑANZA: 
                    <span style="font-family: 'Inter', sans-serif; font-size: 11px; margin: 0; color: blue; color: #002138;">{{ $asis[0]->tema }}</span>
                </p>
            </div>            
            <div>
                <p style="font-family: 'Inter', sans-serif; font-size: 11px; font-weight: bold; margin: 0; color: #000;">OFRENDAS:
                    @if($asis[0]->ofrenda != '')
                        <span style="font-family: 'Inter', sans-serif; font-size: 11px; margin: 0; color: blue; color: #002138;">S/. {{ $asis[0]->ofrenda }}</span>
                    @endif
                </p>
            </div>            
        </div>
    </div>    
    <div>
        <u style="font-family: 'Inter', sans-serif; font-size: 12px; font-weight: bold;">REGISTRO DE ASISTENCIA</u>        
        <div style="margin-top: 10px;">
            <table id="table">
                <thead>
                    <tr>
                        <th>ITEM</th>
                        <th>DISCIPULOS</th>
                        <!-- <th>CARGO</th> -->
                        <th>ASISTENCIA</th>
                    </tr>
                </thead>
                <tbody> 
                    <?php $i=0; ?>
                    @foreach($asistencias as $asistencia)
                        <?php $i++; ?>
                        <tr>
                            <td class="td">{{ $i }}</td>
                            <td class="td" style="text-align: left !important; padding-left: 10px;">{{ $asistencia->nomapecon }}</td>
                            <!-- <td class="td">SIN CARGO</td> -->                            
                            @if($asistencia->asistio == 1)                                
                                <td class="td" style="color: blue;"">SI</td>
                            @else
                                <td class="td" style="color: red;">NO</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div id="data">
            <div style="text-align: center; margin-top: 10px;">
                <div>
                    <p style="font-family: 'Inter', sans-serif; font-size: 11px; font-weight: bold; margin: 0; color: #000;">ASISTENTES: 
                        <span style="font-family: 'Inter', sans-serif; font-size: 11px; margin: 0; color: blue; color: #002138;">{{ $asis[0]->totasistencia }}</span>
                    </p>
                </div>            
                <div>
                    <p style="font-family: 'Inter', sans-serif; font-size: 11px; font-weight: bold; margin: 0; color: #000;">FALTANTES: 
                        <span style="font-family: 'Inter', sans-serif; font-size: 11px; margin: 0; color: blue; color: red;">{{ $asis[0]->totfaltas }}</span>
                    </p>
                </div>
                <p style="font-family: 'Inter', sans-serif; font-size: 12px; font-weight: bold;">TESTIMONIOS</p>
                @if($asis[0]->testimonios == '')
                    <p style="font-family: 'Inter', sans-serif; font-size: 11px;">NO HAY TESTIMONIOS</p>
                @else
                    <p style="font-family: 'Inter', sans-serif; font-size: 11px; text-align: left;">{{ $asis[0]->testimonios }}</p>
                @endif                
                <p style="font-family: 'Inter', sans-serif; font-size: 12px; font-weight: bold;">OBSERVACIONES</p>
                @if($asis[0]->observaciones == '')
                    <p style="font-family: 'Inter', sans-serif; font-size: 11px;">NO HAY OBSERVACIONES</p>
                @else
                    <p style="font-family: 'Inter', sans-serif; font-size: 11px; text-align: left; margin-left: 10px;">{{ $asis[0]->observaciones }}</p>
                @endif
            </div>                        
        </div>
</body>
