<?php setlocale(LC_ALL,'es_PE'); ?>
<head>
    <meta charset="utf-8">
    <meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″ />
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" href="{{ asset('css/app.css') }}">     -->
    <title>Reporte Asistencias cultos liderazgo</title>
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
            /* background-color: #000;
            color: white; */
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
    <!-- <img src="{{ asset('dist/img/logo.png') }}" alt="Logo" width="50" height="50" align="right"> -->        
    <div>
        <table>
            <tr>
                <td>
                    <p style="margin-top: -8px; font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial;color:#000000">
                    <?php 
                        echo date('Y-m-d');
                    ?>
                    </p>
                </td>
                <td>
                    <p style="margin-top: -8px; font-style:normal;font-weight:bold;font-size:9pt;font-family:Arial;color:#000000"> 
                    <?php 
                        echo date('H:i:s a');
                        // 3:26 p.m.
                    ?>
                    </p>
                </td>
            </tr>
        </table>
        <p style="margin-top: -8px; font-family: 'Inter', sans-serif; font-size: 20px; font-weight: bold; text-align: center;">FALTA DEL LIDERAZGO</p>    
        <p style="margin-top: -15px; font-family: 'Inter', sans-serif; font-size: 12px; font-weight: bold; text-align: center;">CULTO: <?php echo strtoupper(strftime("%A", DateTime::createFromFormat("D", $fecha))); ?> {{ $fecha }}</p>



        
        @foreach($discipulados as $disp)
        <?php $codarea = $disp->CodArea; ?>
        <br>
            <table style="margin-top: -10px;">
                <tr>
                    <td style="width: 40%">
                        <p style="font-family: 'Inter', sans-serif; font-size: 11px; font-weight: bold">Tipo de Grupo: DISCIPULADO</p>            
                    </td>
                </tr>            
                <tr>
                    <td style="width: 40%; text-align: center;">
                        <p style="font-family: 'Inter', sans-serif; font-size: 11px; font-weight: bold; text-align: center">Descripción: {{ $disp->DesArea }}</p> 
                    </td>        
                </tr>    
            </table>          
        <hr style="border: 0 none; border-top: 2px dashed #332f32; background: none; height: 0; margin-top: -5px;">
        <table id="table">
            <thead>
                <tr>
                    <td style="text-align: center; width: 5%">
                        <span style="font-family: 'Inter', sans-serif; font-size: 11.5px; font-weight: bold; text-align: center;">N°</span>
                    </td>
                    <td style="text-align: center; width: 10%">
                        <span style="font-family: 'Inter', sans-serif; font-size: 11.5px; font-weight: bold; text-align: center;">Código</span>
                    </td>
                    <td style="width: 25%;">
                        <span style="font-family: 'Inter', sans-serif; font-size: 11.5px; font-weight: bold; text-align: center;">Discípulo</span>
                    </td>
                    <td style="text-align: center; width: 25%">
                        <span style="font-family: 'Inter', sans-serif; font-size: 11.5px; font-weight: bold; text-align: center;">Cargo</span>
                    </td>
                    <td style="width: 35%;"></td>
                </tr>
            </thead>
            <tbody>
                <?php 
                $i = 1; 
                $mentor = 0;
                $lidercdp = 0;
                $sublider = 0;
                ?>
                @foreach($discipulos as $dis)
                @if($dis['CodArea'] == $codarea)
                    <tr>         
                        <td style="text-align: center; width: 5%">
                            <span style="font-family: 'Inter', sans-serif; font-size: 9px; font-weight: bold; text-align: center">{{ $i }}</span>
                        </td>
                        <td style="text-align: center; width: 10%">
                            <span style="font-family: 'Inter', sans-serif; font-size: 9px; font-weight: bold; text-align: center">{{ $dis['CodCon'] }}</span>
                        </td>
                        <td style="width: 25%;">
                            <span style="font-family: 'Inter', sans-serif; font-size: 9px; font-weight: bold; text-align: center; color: #de214a;">{{ $dis['NomApeCon'] }}</span>
                        </td>
                        <td style="text-align: center; width: 25%;">
                            <span style="text-align: center; font-family: 'Inter', sans-serif; font-size: 9px; font-weight: bold; text-align: center; color: #de214a;">{{ $dis['CarDis'] }}</span>
                        </td>
                        <td style="width: 35%;"></td>
                    </tr> 
                    <?php 
                    $i++; 
                    switch($dis['CarDis']){
                        case 'MENTOR';
                            $mentor++;
                        break;
                        case 'LIDER CDP';
                            $lidercdp++;
                            break;
                        case 'SUBLIDER CDP';
                            $sublider++;
                            break;
                    }
                    ?>
                @endif                    
                @endforeach                
                <!-- <tr>
                    <td style="text-align: center; width: 15%;">
                        <span style="text-align: center; font-family: 'Inter', sans-serif; font-size: 9px; font-weight: bold; text-align: center; color: #de214a;">{{ $i }}</span>
                    </td>
                </tr> -->
            </tbody>                
            <p style="font-family: 'Inter', sans-serif; font-size: 11px; font-weight: bold; text-align: left">{{ $mentor }} mentores, {{ $lidercdp }} líderes de casas de paz y {{ $sublider }} sublíderes de casa de paz</p>
        </table>        
        @endforeach
    </div>
</body>
