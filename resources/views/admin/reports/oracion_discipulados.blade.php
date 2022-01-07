<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" href="{{ asset('css/app.css') }}">     -->
    <title>Reporte de oración</title>
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
    <div>
        <table>
            <tr>
                <td>
                    <span style="font-family: 'Inter', sans-serif; font-size: 8pt; font-weight: bold; text-align: center">
                    <?php 
                        echo date('Y-m-d');
                    ?>
                    </span>
                </td>
                <td>
                    <span style="font-family: 'Inter', sans-serif; font-size: 8pt; font-weight: bold; text-align: center">  
                    <?php 
                        echo date('H:i:s a');
                        // 3:26 p.m.
                    ?>
                    </p>
                </td>
            </tr>
        </table>
        <p style="margin-top: -8px; font-family: 'Inter', sans-serif; font-size: 20px; font-weight: bold; text-align: center;">Reporte de Oración</p>    



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
                    <td style="width: 36%;"></td>
                    <td style="text-align: center; width: 8%">
                        <span style="font-family: 'Inter', sans-serif; font-size: 11.5px; font-weight: bold; text-align: center;">Lunes</span>                                    
                    </td>
                    <td style="text-align: center; width: 8%">
                        <span style="font-family: 'Inter', sans-serif; font-size: 11.5px; font-weight: bold; text-align: center;">Martes</span>                                    
                    </td>
                    <td style="text-align: center; width: 8%">
                        <span style="font-family: 'Inter', sans-serif; font-size: 11.5px; font-weight: bold; text-align: center;">Miercoles</span>                                    
                    </td>
                    <td style="text-align: center; width: 8%">
                        <span style="font-family: 'Inter', sans-serif; font-size: 11.5px; font-weight: bold; text-align: center;">Jueves</span>                                    
                    </td>
                    <td style="text-align: center; width: 8%">
                        <span style="font-family: 'Inter', sans-serif; font-size: 11.5px; font-weight: bold; text-align: center;">Viernes</span>                                    
                    </td>
                    <td style="text-align: center; width: 8%">
                        <span style="font-family: 'Inter', sans-serif; font-size: 11.5px; font-weight: bold; text-align: center;">Sabado</span>                                    
                    </td>
                    <td style="text-align: center; width: 8%">    
                        <span style="font-family: 'Inter', sans-serif; font-size: 11.5px; font-weight: bold; text-align: center;">Domingo</span>                                                        
                    </td>
                    <td style="text-align: center; width: 8%">
                        <span style="font-family: 'Inter', sans-serif; font-size: 11.5px; font-weight: bold; text-align: center;">Asistencia</span>                                    
                    </td>
                </tr>                
            </thead>
            <tbody>
                @foreach($discipulos as $dis)
                    @if($dis->CodArea == $codarea)
                    <tr>         
                        @if($dis->TotAsi == 1 && $dis->NumAsi < 1)
                            <td style="width: 36%;">
                                <span style="font-family: 'Inter', sans-serif; font-size: 9px; font-weight: bold; text-align: center; margin-left: 18px; color: #de214a;">{{ $dis->ApeCon.' '.$dis->NomCon }}</span>
                            </td>
                        @else
                            @if($dis->TotAsi == 2 && $dis->NumAsi < 1)
                                <td style="width: 36%;">
                                    <span style="font-family: 'Inter', sans-serif; font-size: 9px; font-weight: bold; text-align: center; margin-left: 18px; color: #de214a;">{{ $dis->ApeCon.' '.$dis->NomCon }}</span>
                                </td>
                            @else
                                @if($dis->TotAsi == 3 && $dis->NumAsi < 2)
                                    <td style="width: 36%;">
                                        <span style="font-family: 'Inter', sans-serif; font-size: 9px; font-weight: bold; text-align: center; margin-left: 18px; color: #de214a;">{{ $dis->ApeCon.' '.$dis->NomCon }}</span>
                                    </td>
                                @else
                                    @if($dis->TotAsi == 4 && $dis->NumAsi < 2)
                                        <td style="width: 36%;">
                                            <span style="font-family: 'Inter', sans-serif; font-size: 9px; font-weight: bold; text-align: center; margin-left: 18px; color: #de214a;">{{ $dis->ApeCon.' '.$dis->NomCon }}</span>
                                        </td>
                                    @else
                                        @if($dis->TotAsi == 5 && $dis->NumAsi < 3)
                                            <td style="width: 36%;">
                                                <span style="font-family: 'Inter', sans-serif; font-size: 9px; font-weight: bold; text-align: center; margin-left: 18px; color: #de214a;">{{ $dis->ApeCon.' '.$dis->NomCon }}</span>
                                            </td>
                                        @else
                                            @if($dis->TotAsi == 6 && $dis->NumAsi < 4)
                                                <td style="width: 36%;">
                                                    <span style="font-family: 'Inter', sans-serif; font-size: 9px; font-weight: bold; text-align: center; margin-left: 18px; color: #de214a;">{{ $dis->ApeCon.' '.$dis->NomCon }}</span>
                                                </td>
                                            @else
                                                @if($dis->TotAsi == 7 && $dis->NumAsi < 5)
                                                    <td style="width: 36%;">
                                                        <span style="font-family: 'Inter', sans-serif; font-size: 9px; font-weight: bold; text-align: center; margin-left: 18px; color: #de214a;">{{ $dis->ApeCon.' '.$dis->NomCon }}</span>
                                                    </td>
                                                @else
                                                    <td style="width: 36%;">
                                                        <span style="font-family: 'Inter', sans-serif; font-size: 9px; font-weight: bold; text-align: center; margin-left: 18px">{{ $dis->ApeCon.' '.$dis->NomCon }}</span>
                                                    </td>
                                                @endif                                        
                                            @endif                                        
                                        @endif                                        
                                    @endif
                                @endif                                
                            @endif
                        @endif
                        <td style="text-align: center; width: 8%">
                            @if($dis->Lunes == 'ASISTIO')
                                <span style="font-family: 'Inter', sans-serif; font-size: 9px; font-weight: bold; text-align: center;">{{ $dis->Lunes }}</span>
                            @else
                                <span style="font-family: 'Inter', sans-serif; font-size: 9px; font-weight: bold; text-align: center; color: #de214a;">{{ $dis->Lunes }}</span>
                            @endif
                        </td>
                        <td style="text-align: center; width: 8%">
                            @if($dis->Martes == 'ASISTIO')
                                <span style="font-family: 'Inter', sans-serif; font-size: 9px; font-weight: bold; text-align: center;">{{ $dis->Martes }}</span>
                            @else
                                <span style="font-family: 'Inter', sans-serif; font-size: 9px; font-weight: bold; text-align: center; color: #de214a;">{{ $dis->Martes }}</span>
                            @endif                        
                        </td>
                        <td style="text-align: center; width: 8%">
                            @if($dis->Miercoles == 'ASISTIO')
                                <span style="font-family: 'Inter', sans-serif; font-size: 9px; font-weight: bold; text-align: center;">{{ $dis->Miercoles }}</span>
                            @else
                                <span style="font-family: 'Inter', sans-serif; font-size: 9px; font-weight: bold; text-align: center; color: #de214a;">{{ $dis->Miercoles }}</span>
                            @endif                        
                        </td>
                        <td style="text-align: center; width: 8%">
                            @if($dis->Jueves == 'ASISTIO')
                                <span style="font-family: 'Inter', sans-serif; font-size: 9px; font-weight: bold; text-align: center;">{{ $dis->Jueves }}</span>
                            @else
                                <span style="font-family: 'Inter', sans-serif; font-size: 9px; font-weight: bold; text-align: center; color: #de214a;">{{ $dis->Jueves }}</span>
                            @endif                        
                        </td>
                        <td style="text-align: center; width: 8%">
                            @if($dis->Viernes == 'ASISTIO')
                                <span style="font-family: 'Inter', sans-serif; font-size: 9px; font-weight: bold; text-align: center;">{{ $dis->Viernes }}</span>
                            @else
                                <span style="font-family: 'Inter', sans-serif; font-size: 9px; font-weight: bold; text-align: center; color: #de214a;">{{ $dis->Viernes }}</span>
                            @endif                        
                        </td>
                        <td style="text-align: center; width: 8%">
                            @if($dis->Sabado == 'ASISTIO')
                                <span style="font-family: 'Inter', sans-serif; font-size: 9px; font-weight: bold; text-align: center;">{{ $dis->Sabado }}</span>
                            @else
                                <span style="font-family: 'Inter', sans-serif; font-size: 9px; font-weight: bold; text-align: center; color: #de214a;">{{ $dis->Sabado }}</span>
                            @endif                        
                        </td>
                        <td style="text-align: center; width: 8%">
                            @if($dis->Domingo == 'ASISTIO')
                                <span style="font-family: 'Inter', sans-serif; font-size: 9px; font-weight: bold; text-align: center;">{{ $dis->Domingo }}</span>
                            @else
                                <span style="font-family: 'Inter', sans-serif; font-size: 9px; font-weight: bold; text-align: center; color: #de214a;">{{ $dis->Domingo }}</span>
                            @endif                        
                        </td>
                        <td style="text-align: center; width: 8%">
                            <span style="font-family: 'Inter', sans-serif; font-size: 9px; font-weight: bold; text-align: center;">{{ $dis->NumAsi.' de '.$dis->TotAsi }}</span>
                        </td>
                    </tr>   
                    @endif
                @endforeach
            </tbody>
        </table>        
        @endforeach
    </div>  
</body>
