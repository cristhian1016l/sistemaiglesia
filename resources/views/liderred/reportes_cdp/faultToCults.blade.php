<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" href="{{ asset('css/app.css') }}">     -->
    <title>Reporte Discipulado</title>
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
    <p style="font-family: 'Inter', sans-serif; font-size: 12x; font-weight: bold; text-align: center;">REPORTE DE VISITAS - {{ $cdp['cdp'] }}</p>
    <div id="left">
        <!-- PRIMERA PARTE -->
        <div>
            <p style="font-family: 'Inter', sans-serif; font-size: 11px; font-weight: bold; margin: 0; color: #000;">LÍDER:
                <span style="font-family: 'Inter', sans-serif;">{{ $cdp['lider'] }}</span>
            </p>
        </div>            
        <u style="font-family: 'Inter', sans-serif; font-size: 12px; font-weight: bold; text-decoration: none;">sub-lider</u>
        <span style="font-family: 'Inter', sans-serif; font-size: 12px; margin: 0; color: blue; color: #002138;">1____________________________________</span>
        <p style="font-family: 'Inter', sans-serif; font-size: 11px; font-weight: bold; margin: 0; color: #000;">
            <span style="font-family: 'Inter', sans-serif; font-size: 11px; margin: 0; color: blue; color: #002138; margin-left: 55px;">2_______________________________________</span>
        </p>        
        <p style="font-family: 'Inter', sans-serif; font-size: 11px; font-weight: bold; margin: 0; color: #000;">
            <span style="font-family: 'Inter', sans-serif; font-size: 11px; margin: 0; color: blue; color: #002138; margin-left: 55px;">3_______________________________________</span>
        </p>        
        <p style="font-family: 'Inter', sans-serif; font-size: 11px; font-weight: bold; margin: 0; color: #000;">
            <span style="font-family: 'Inter', sans-serif; font-size: 11px; margin: 0; color: blue; color: #002138; margin-left: 55px;">4_______________________________________</span>
        </p> 
        <!-- PRIMERA PARTE FIN -->
        
        <!-- SEGUNDA PARTE -->
        <div>
            <p style="font-family: 'Inter', sans-serif; font-size: 11px; font-weight: bold; margin: 0; color: #000;">Discípulo y/o miembros que les acompañaron:</p>
        </div>                    
        <p style="font-family: 'Inter', sans-serif; font-size: 11px; font-weight: bold; margin: 0; color: #000;">
            <span style="font-family: 'Inter', sans-serif; font-size: 11px; margin: 0; color: blue; color: #002138; margin-left: 5px;">1. ______________________________________________________</span>
        </p>        
        <p style="font-family: 'Inter', sans-serif; font-size: 11px; font-weight: bold; margin: 0; color: #000;">
            <span style="font-family: 'Inter', sans-serif; font-size: 11px; margin: 0; color: blue; color: #002138; margin-left: 5px;">2. ______________________________________________________</span>
        </p>        
        <p style="font-family: 'Inter', sans-serif; font-size: 11px; font-weight: bold; margin: 0; color: #000;">
            <span style="font-family: 'Inter', sans-serif; font-size: 11px; margin: 0; color: blue; color: #002138; margin-left: 5px;">3. ______________________________________________________</span>
        </p>        
        <p style="font-family: 'Inter', sans-serif; font-size: 11px; font-weight: bold; margin: 0; color: #000;">
            <span style="font-family: 'Inter', sans-serif; font-size: 11px; margin: 0; color: blue; color: #002138; margin-left: 5px;">4. ______________________________________________________</span>
        </p> 
        <!-- SEGUNDA PARTE FIN -->

    </div>    
    <div id="right">
        <!-- PRIMERA PARTE -->
        <p style="font-family: 'Inter', sans-serif; font-size: 11px; font-weight: bold; margin: 0; color: #000; margin-left: 150px;">Firma ______________________________ 
        <p style="font-family: 'Inter', sans-serif; font-size: 11px; font-weight: bold; margin: 0; color: #000; margin-left: 150px;">Firma ______________________________ 
        <p style="font-family: 'Inter', sans-serif; font-size: 11px; font-weight: bold; margin: 0; color: #000; margin-left: 150px;">Firma ______________________________ 
        <p style="font-family: 'Inter', sans-serif; font-size: 11px; font-weight: bold; margin: 0; color: #000; margin-left: 150px;">Firma ______________________________         
        <p style="font-family: 'Inter', sans-serif; font-size: 11px; font-weight: bold; margin: 0; color: #000; margin-left: 150px;">Firma ______________________________         
        <!-- PRIMERA PARTE FIN -->

        <!-- SEGUNDA PARTE -->
        <p style="font-family: 'Inter', sans-serif; font-size: 11px; font-weight: bold; margin: 0; color: #000; margin-left: 150px; color: white">....................................
        <p style="font-family: 'Inter', sans-serif; font-size: 11px; font-weight: bold; margin: 0; color: #000; margin-left: 150px;">Firma ______________________________ 
        <p style="font-family: 'Inter', sans-serif; font-size: 11px; font-weight: bold; margin: 0; color: #000; margin-left: 150px;">Firma ______________________________         
        <p style="font-family: 'Inter', sans-serif; font-size: 11px; font-weight: bold; margin: 0; color: #000; margin-left: 150px;">Firma ______________________________         
        <p style="font-family: 'Inter', sans-serif; font-size: 11px; font-weight: bold; margin: 0; color: #000; margin-left: 150px;">Firma ______________________________         
        <!-- SEGUNDA PARTE FIN -->
    </div>    
    <div>
        <u style="font-family: 'Inter', sans-serif; font-size: 12px; font-weight: bold; text-decoration: none;">VISITAS A LOS MIEMBROS QUE FALTARON EL DOMINGO</u>        
        <div style="margin-top: 10px;">
            <table id="table">
                <thead>                    
                    <tr>
                        <th style="width: 5%">N°</th>
                        <th style="width: 30%">APELLIDOS Y NOMBRES</th>
                        <th style="width: 10%">CELULAR</th>
                        <th style="width: 55%">¿CÓMO LES FUE?</th>
                    </tr>                    
                </thead>
                <tbody> 
                    @foreach($cdp['members'] as $key=>$member)
                    <tr>
                        <td class="td">{{ $key+1 }}</td>
                        <td class="td" style="text-align: left !important; padding-left: 10px;">{{ $member->NomApeCon }}</td>
                        <td class="td">{{ $member->NumCel }}</td>
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
