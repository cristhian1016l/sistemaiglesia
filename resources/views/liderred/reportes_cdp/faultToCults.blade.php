<?php setlocale(LC_ALL,'es_PE'); ?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" href="{{ asset('css/app.css') }}">     -->
    <title>Reporte de visitas</title>
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
            background-color: #000;
            color: white;
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
    @foreach($cdps as $cdp)
        <p style="font-family: 'Inter', sans-serif; font-size: 12x; font-weight: bold; text-align: center; margin-top: -15px;">VISITA SEMANAL - {{ $cdp['cdp'] }}</p>
        <p style="font-family: 'Inter', sans-serif; font-size: 10x; font-weight: bold; text-align: center; margin-top: -20px;">Listado de Miembros de Casa de Paz</p>
        <p style="font-family: 'Inter', sans-serif; font-size: 10x; font-weight: bold; text-align: center; margin-top: -10px;">Reporte a la Fecha: <?php echo date('Y-m-d'); ?></p>
        <hr style="border: none; border-top: 1px dashed #f00; color: #fff; background-color: #fff; height: 1px; width: 100%;">    
        <?php $vuelta = 0; ?>        
        @foreach($cdp['members'] as $key=>$member)
        <div id="left">
            <table id="table">
                <tr>
                    <td class="td" style="width: 10%; border: none; font-weight: bold;">{{ $key+1 }}</td>
                    <td class="td" style="width: 30%; border: none; font-weight: bold; text-align: left;">{{ $member['miembro']->ApeCon.' '.$member['miembro']->NomCon }}</td>
                    <td class="td" style="width: 30%; border: none; font-weight: bold;">VISITAR</td>
                    <td class="td" style="width: 30%; border: none; font-weight: bold;">{{ $member['miembro']->TipCon }}</td>
                </tr>
            </table><br/>
            <hr style="border: none; border-top: 1px dashed #f00; color: #fff; background-color: #fff; height: 1px; width: 90%; margin-top: 10px;"><br/>
            <hr style="border: none; border-top: 1px dashed #f00; color: #fff; background-color: #fff; height: 1px; width: 90%; margin-top: -15px"><br/>        
            <hr style="border: none; border-top: 1px dashed #f00; color: #fff; background-color: #fff; height: 1px; width: 90%; margin-top: -20px"><br/>        
        </div>   
        <div id="right">
            <div id=tabla1 style="border: 1px solid #1E679A; width: 550px">
                <div id=cabtab1 style="background-color: #1E679A; font-weight: bold; color: #ffffff; padding: 2 2 2 2px; font-size: 11px; text-align: center;">
                    FALTÓ AL ÚLTIMO CULTO
                </div>
                <div id=cuerpotab1 style="padding: 4 4 4 4px; font-size: 11px; font-weight: bold;">
                    ¿Considera que se debe seguir trabajando con El(la)?
                    SI
                    <label style="width: 20px; height: 20px; background: #fff; border: 1px solid #000; font-size: 11px;">&nbsp;&nbsp;&nbsp;&nbsp;</label>
                    NO
                    <label style="width: 20px; height: 20px; background: #fff; border: 1px solid #000; font-size: 11px;">&nbsp;&nbsp;&nbsp;&nbsp;</label>
                </div>
                <div id=cuerpotab1 style="padding: 4 4 4 4px; font-size: 11px; font-weight: bold; margin-top: -10px;">
                    ¿Motivo de su inasistencia?&nbsp;&nbsp;&nbsp;&nbsp;
                    TRABAJO
                    <label style="width: 20px; height: 20px; background: #fff; border: 1px solid #000; font-size: 11px;">&nbsp;&nbsp;&nbsp;&nbsp;</label>
                    ESTUDIOS
                    <label style="width: 20px; height: 20px; background: #fff; border: 1px solid #000; font-size: 11px;">&nbsp;&nbsp;&nbsp;&nbsp;</label>
                    OTROS
                    <label style="width: 20px; height: 20px; background: #fff; border: 1px solid #000; font-size: 11px;">&nbsp;&nbsp;&nbsp;&nbsp;</label>
                </div>
            </div>
        </div>    
        <br/><br/><br/><br/><br/>
        <?php $vuelta++ ?>
        @if($vuelta == 5)
        <div style="page-break-after:always;"></div>
        <?php $vuelta = 0; ?>
        @endif
        @endforeach    
    <div style="page-break-after:always;"></div>
    @endforeach
</body>
