<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" href="{{ asset('css/app.css') }}">     -->
    <title>Reporte Almas Nuevas</title>
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
    </style>
</head>
<body>
    <!-- <img src="{{ asset('dist/img/logo.png') }}" alt="Logo" width="50" height="50" align="right"> -->        
    <div>
        <!-- <u style="font-family: 'Inter', sans-serif; font-size: 12px; font-weight: bold;">REGISTRO DE ASISTENCIA</u>         -->
        <p style="font-family: 'Inter', sans-serif; font-size: 12x; font-weight: bold; text-align: center;">ASISTENCIAS POR CASAS DE PAZ</p>    
        <div style="margin-top: 10px;">
            <hr style="border-top: 1px trashed;">
            <table id="table">
                <tbody>
                    <?php                            
                        $meses = [ 1 => 'ENERO', 2 => 'FEBRERO', 3 => 'MARZO', 4 => 'ABRIL', 5=> 'MAYO', 6 => 'JUNIO', 7 => 'JULIO', 8 => 'AGOSTO', 9 => 'SETIEMBRE', 10 => 'OCTUBRE', 11 => 'NOVIEMBRE', 12 => 'DICIEMBRE'];
                        $meses_abr = [ 1 => 'ENE', 2 => 'FEB', 3 => 'MAR', 4 => 'ABR', 5=> 'MAY', 6 => 'JUN', 7 => 'JUL', 8 => 'AGO', 9 => 'SET', 10 => 'OCT', 11 => 'NOV', 12 => 'DIC'];
                        $dias = [ 1 => 'LUNES', 2 => 'MARTES', 3 => 'MIÉRCOLES', 4 => 'JUEVES', 5=> 'VIERNES', 6 => 'SÁBADO', 7 => 'DOMINGO'];                        
                    ?>
                        <!-- ESPACIADO -->
                        <tr>
                            <td style="padding-top: 20px;"></td>
                        </tr>        
                        <!-- FIN ESPACIADO -->                    
                        <tr>
                            <td></td>
                            <td colspan="2" bgcolor="#0b2d6b" style="color: white; font-weight: bold; font-size: 12px; text-align: center; padding-bottom: 3px;">{{ $cdp }}</td>
                        </tr>
                        <tr>
                            <td class="td" style="font-weight: bold; width: 3%"></td>
                            <td class="td" style="font-weight: bold; width: 19%" bgcolor="#a0bfd9">APELLIDOS Y NOMBRES</td>
                            <td class="td" style="font-weight: bold; width: 8%" bgcolor="#a0bfd9">CELULAR</td>
                            @foreach(array_reverse($asistencias) as $asistencia)
                                <td class="td" style="font-weight: bold; width: 7%" bgcolor="#e0eb1c"><?php echo date('d', strtotime($asistencia->FecAsi)).'-'.$meses_abr[date('n', strtotime($asistencia->FecAsi))];  ?></td>
                            @endforeach                            
                            <td class="td" style="font-weight: bold; width: 6%" bgcolor="#f5da5f">FALTAS</td>
                        </tr>                        
                        <?php $i = 1; ?>
                        @foreach($members as $member)                            
                            @if($member['faltas']>2)
                                <tr style="background-color: #e0eb1c;">
                            @else
                                <tr>
                            @endif 
                                <td class="td">{{ $i }}</td>
                                <td class="td" style="text-align: left;">{{ $member['Nombrescomp'] }}</td>
                                <td class="td" style="text-align: center;">{{ $member['NumCel'] }}</td>
                                @switch($member['asis5'])
                                    @case('F')
                                        <td class="td" style="text-align: center !important; color: red; border: 1px solid #ddd; font-weight: bold;">FALTÓ</td>
                                        @break
                                    @case('A')
                                        <td class="td" style="text-align: center !important; border: 1px solid #ddd; font-weight: bold;">ASISTIÓ</td>
                                        @break
                                    @case('T')
                                        <td class="td" style="text-align: center !important; border: 1px solid #ddd; font-weight: bold;">ASISTIÓ</td>
                                        @break
                                    @case('P')
                                        <td class="td" style="text-align: center !important; color: #3a73a6; border: 1px solid #ddd; font-weight: bold;">PERMISO</td>
                                        @break                                    
                                    @default
                                        <td class="td" style="text-align: center !important; border: 1px solid #ddd; font-weight: bold;">----</td>
                                        @break
                                @endswitch                                
                                @switch($member['asis4'])
                                    @case('F')
                                        <td class="td" style="text-align: center !important; color: red; border: 1px solid #ddd; font-weight: bold;">FALTÓ</td>
                                        @break
                                    @case('A')
                                        <td class="td" style="text-align: center !important; border: 1px solid #ddd; font-weight: bold;">ASISTIÓ</td>
                                        @break
                                    @case('T')
                                        <td class="td" style="text-align: center !important; border: 1px solid #ddd; font-weight: bold;">ASISTIÓ</td>
                                        @break
                                    @case('P')
                                        <td class="td" style="text-align: center !important; color: #3a73a6; border: 1px solid #ddd; font-weight: bold;">PERMISO</td>
                                        @break                                    
                                    @default
                                        <td class="td" style="text-align: center !important; border: 1px solid #ddd; font-weight: bold;">----</td>
                                        @break
                                @endswitch                                
                                @switch($member['asis3'])
                                    @case('F')
                                        <td class="td" style="text-align: center !important; color: red; border: 1px solid #ddd; font-weight: bold;">FALTÓ</td>
                                        @break
                                    @case('A')
                                        <td class="td" style="text-align: center !important; border: 1px solid #ddd; font-weight: bold;">ASISTIÓ</td>
                                        @break
                                    @case('T')
                                        <td class="td" style="text-align: center !important; border: 1px solid #ddd; font-weight: bold;">ASISTIÓ</td>
                                        @break
                                    @case('P')
                                        <td class="td" style="text-align: center !important; color: #3a73a6; border: 1px solid #ddd; font-weight: bold;">PERMISO</td>
                                        @break                                    
                                    @default
                                        <td class="td" style="text-align: center !important; border: 1px solid #ddd; font-weight: bold;">----</td>
                                        @break
                                @endswitch                                
                                @switch($member['asis2'])
                                    @case('F')
                                        <td class="td" style="text-align: center !important; color: red; border: 1px solid #ddd; font-weight: bold;">FALTÓ</td>
                                        @break
                                    @case('A')
                                        <td class="td" style="text-align: center !important; border: 1px solid #ddd; font-weight: bold;">ASISTIÓ</td>
                                        @break
                                    @case('T')
                                        <td class="td" style="text-align: center !important; border: 1px solid #ddd; font-weight: bold;">ASISTIÓ</td>
                                        @break
                                    @case('P')
                                        <td class="td" style="text-align: center !important; color: #3a73a6; border: 1px solid #ddd; font-weight: bold;">PERMISO</td>
                                        @break                                    
                                    @default
                                        <td class="td" style="text-align: center !important; border: 1px solid #ddd; font-weight: bold;">----</td>
                                        @break
                                @endswitch                                
                                @switch($member['asis1'])
                                    @case('F')
                                        <td class="td" style="text-align: center !important; color: red; border: 1px solid #ddd; font-weight: bold;">FALTÓ</td>
                                        @break
                                    @case('A')
                                        <td class="td" style="text-align: center !important; border: 1px solid #ddd; font-weight: bold;">ASISTIÓ</td>
                                        @break
                                    @case('T')
                                        <td class="td" style="text-align: center !important; border: 1px solid #ddd; font-weight: bold;">ASISTIÓ</td>
                                        @break
                                    @case('P')
                                        <td class="td" style="text-align: center !important; color: #3a73a6; border: 1px solid #ddd; font-weight: bold;">PERMISO</td>
                                        @break                                    
                                    @default
                                        <td class="td" style="text-align: center !important; border: 1px solid #ddd; font-weight: bold;">----</td>
                                        @break
                                @endswitch                                
                                @if($member['faltas']>2)
                                    <td class="td" style="text-align: center !important; color: red; border: 1px solid #ddd; font-weight: bold;">{{ $member['faltas'] }}</td>
                                @else
                                    <td class="td" style="text-align: center !important; border: 1px solid #ddd; font-weight: bold;">{{ $member['faltas'] }}</td>
                                @endif
                            </tr>
                            <?php $i++; ?>                          
                        @endforeach
                </tbody>
            </table>
        </div>
</body>
