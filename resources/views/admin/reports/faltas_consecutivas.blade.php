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
        <p style="font-family: 'Inter', sans-serif; font-size: 12x; font-weight: bold; text-align: center;">FALTAS CONSECUTIVAS A LOS CULTOS</p>    
        <div style="margin-top: 10px;">
            <hr style="border-top: 1px dashed red;">
            <table id="table">
                <thead>
                    <tr>
                        <th></th>
                        <th></th>>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody> 
                    <?php $codareaverif = ""; ?>
                    @foreach($faltas as $falta)
                        <?php 
                            $codarea = $falta->Codarea;
                            if($codarea != $codareaverif)
                            {
                                ?>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="td" style="text-align: left !important;
                                            font-weight: bold; padding: 15px;">{{ $falta->Desarea }}</td>
                                    </tr>
                                <?php
                            }
                        ?>
                        <tr>
                            <td class="td" style="text-align: left !important; color: red; border: 1px solid #ddd;">{{ $falta->Codcon }}</td>
                            <td class="td" style="text-align: left !important; color: red; border: 1px solid #ddd;">{{ $falta->Nombrescomp }}</td>
                            <td class="td" style="text-align: left !important;
                                font-weight: bold; border: 1px solid #ddd;">{{ $falta->Cargo }}</td>
                            <td class="td" style="text-align: left !important; color: red; border: 1px solid #ddd;">{{ $falta->Motivo }}</td>
                        </tr>
                        <?php $codareaverif = $falta->Codarea; ?>
                    @endforeach
                </tbody>
            </table>
        </div>
</body>
