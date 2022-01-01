<?php setlocale(LC_ALL,'es_PE'); ?>
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
        <!-- <u style="font-family: 'Inter', sans-serif; font-size: 12px; font-weight: bold;">REGISTRO DE ASISTENCIA</u>         -->
        <p style="font-family: 'Inter', sans-serif; font-size: 12x; font-weight: bold; text-align: center;">FALTAS AL DISCIPULADO (ÚLTIMOS 3 MESES)</p>    
        <h4>Sólo se muestran los que tienen al menos una falta</h4>
        <div style="margin-top: 10px;">
            <hr style="border-top: 1px dashed red;">
            <table id="table">
                <tbody> 
                    <?php
                        $meses = [ 1 => 'ENERO', 2 => 'FEBRERO', 3 => 'MARZO', 4 => 'ABRIL', 5=> 'MAYO', 6 => 'JUNIO', 7 => 'JULIO', 8 => 'AGOSTO', 9 => 'SEPTIEMBRE', 10 => 'OCTUBRE', 11 => 'NOVIEMBRE', 12 => 'DICIEMBRE'];
                        $mesesreporte = array();
                        switch(date('m')){
                            case 1:
                                $mesesreporte[0] = "ENERO";
                                $mesesreporte[1] = "DICIEMBRE";
                                $mesesreporte[2] = "NOVIEMBRE";
                                break;
                            case 2:
                                $mesesreporte[0] = "FEBRERO";
                                $mesesreporte[1] = "ENERO";
                                $mesesreporte[2] = "DICIEMBRE";
                                break;
                            case 3:
                                $mesesreporte[0] = "MARZO";
                                $mesesreporte[1] = "FEBRERO";
                                $mesesreporte[2] = "ENERO";
                                break;
                            default:
                                $mesesreporte[0] = $meses[date('m')];
                                $mesesreporte[1] = $meses[date('m')-1];
                                $mesesreporte[2] = $meses[date('m')-2];
                        }                        
                    ?>
                    <?php $codareaverif = ""; ?>
                    @foreach($faltas as $falta)
                        <?php 
                            $codarea = $falta['Codarea'];
                            if($codarea != $codareaverif)
                            {
                                ?>
                                    <tr style="margin-top: 10px;">
                                        <td colspan="7" style="font-size: 13px; font-weight: bold;">{{ $falta['Desarea'] }}</td>
                                    </tr>                                    
                                    <tr style="padding: 25px;">
                                        <td class="td" style="width: 8%"></td>
                                        <td class="td" style="width: 31%"></td>
                                        <td class="td" style="width: 12%"></td>
                                        <td class="td" style="text-align: left !important; border: 1px solid #ddd; width: 11%; font-weight: bold"><?php echo $mesesreporte[2]; ?></td>
                                        <td class="td" style="text-align: left !important; border: 1px solid #ddd; width: 11%; font-weight: bold"><?php echo $mesesreporte[1]; ?></td>
                                        <td class="td" style="text-align: left !important; border: 1px solid #ddd; width: 11%; font-weight: bold"><?php echo $mesesreporte[0]; ?></td>
                                        <td class="td" style="text-align: left !important; border: 1px solid #ddd; width: 11%; font-weight: bold">TOTAL</td>
                                    </tr>
                                <?php
                            }
                        ?>
                        <tr>
                            @if($falta['total']>1)
                                <td class="td" bgcolor="#d2d2d2" style="text-align: left !important; color: red; border: 1px solid #ddd; font-weight: bold;">{{ $falta['Codcon'] }}</td>                            
                                <td class="td" bgcolor="#d2d2d2" style="text-align: left !important; color: red; border: 1px solid #ddd; font-weight: bold;">{{ $falta['Nombrescomp'] }}</td>
                                <td class="td" bgcolor="#d2d2d2" style="text-align: left !important; color: red; border: 1px solid #ddd; font-weight: bold;">{{ $falta['Cargo'] }}</td>
                                @if($falta['mes1'] == 1)
                                    <td class="td" bgcolor="#d2d2d2" style="text-align: left !important; border: 1px solid #ddd; font-weight: bold;">ASISTIÓ</td>
                                @else
                                    <td class="td" bgcolor="#d2d2d2" style="text-align: left !important; color: red; border: 1px solid #ddd; font-weight: bold;">FALTÓ</td>
                                @endif                                                                
                                @if($falta['mes2'] == 1)
                                    <td class="td" bgcolor="#d2d2d2" style="text-align: left !important; border: 1px solid #ddd; font-weight: bold;">ASISTIÓ</td>
                                @else
                                    <td class="td" bgcolor="#d2d2d2" style="text-align: left !important; color: red; border: 1px solid #ddd; font-weight: bold;">FALTÓ</td>
                                @endif                                                                
                                @if($falta['mes3'] == 1)
                                    <td class="td" bgcolor="#d2d2d2" style="text-align: left !important; border: 1px solid #ddd; font-weight: bold;">ASISTIÓ</td>
                                @else
                                    <td class="td" bgcolor="#d2d2d2" style="text-align: left !important; color: red; border: 1px solid #ddd; font-weight: bold;">FALTÓ</td>
                                @endif                                                                
                                <td class="td" bgcolor="#d2d2d2" style="text-align: left !important; color: red; border: 1px solid #ddd; font-weight: bold;">{{ $falta['total'].' FALTAS' }}</td>
                            @else
                                <td class="td" style="text-align: left !important; border: 1px solid #ddd; font-weight: bold;">{{ $falta['Codcon'] }}</td>                            
                                <td class="td" style="text-align: left !important; border: 1px solid #ddd; font-weight: bold;">{{ $falta['Nombrescomp'] }}</td>
                                <td class="td" style="text-align: left !important; border: 1px solid #ddd; font-weight: bold;">{{ $falta['Cargo'] }}</td>
                                @if($falta['mes1'] == 1)
                                    <td class="td" style="text-align: left !important; border: 1px solid #ddd; font-weight: bold;">ASISTIÓ</td>
                                @else
                                    <td class="td" style="text-align: left !important; color: red; border: 1px solid #ddd; font-weight: bold;">FALTÓ</td>
                                @endif                                                                
                                @if($falta['mes2'] == 1)
                                    <td class="td" style="text-align: left !important; border: 1px solid #ddd; font-weight: bold;">ASISTIÓ</td>
                                @else
                                    <td class="td" style="text-align: left !important; color: red; border: 1px solid #ddd; font-weight: bold;">FALTÓ</td>
                                @endif                                                                
                                @if($falta['mes3'] == 1)
                                    <td class="td" style="text-align: left !important; border: 1px solid #ddd; font-weight: bold;">ASISTIÓ</td>
                                @else
                                    <td class="td" style="text-align: left !important; color: red; border: 1px solid #ddd; font-weight: bold;">FALTÓ</td>
                                @endif                 
                                <td class="td" style="text-align: left !important; border: 1px solid #ddd; font-weight: bold;">{{ $falta['total'].' FALTA' }}</td>
                            @endif                                                        
                        </tr>
                        <?php $codareaverif = $falta['Codarea']; ?>
                    @endforeach
                </tbody>
            </table>
        </div>
</body>
