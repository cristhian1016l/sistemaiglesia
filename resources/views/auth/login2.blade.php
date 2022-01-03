<!DOCTYPE html>
<html lang="en">
<head>
     <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Iniciar Sesión - Ministerio Internacional Avivamiento y fuego</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="{{ asset('dist/img/logo-miaf.ico') }}" />
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('plugins/bootstrap-login/css/bootstrap.min.css') }} ">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
<!--===============================================================================================-->
	<!-- <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css"> -->
<!--===============================================================================================-->	
	<!-- <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css"> -->
<!--===============================================================================================-->
	<!-- <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css"> -->
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('css/login/util.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/login/main.css') }}">
<!--===============================================================================================-->
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="{{ asset('/dist/img/logo-miaf.jpg') }}" alt="IMG" style="border-radius: 150px;">
				</div>

				<form class="login100-form validate-form" method="POST" action="{{ route('login') }}">
                    @csrf
					<span class="login100-form-title">
						Login - sistema MIAF
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Usuario incorrecto: .@iglesiaprimitivaperu.org">
						<input id="email" class="input100" type="text" name="email" placeholder="Usuario">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Contraseña es requerida">
						<input class="input100" type="password" name="password" placeholder="Contraseña">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button type="submit" name="button" class="login100-form-btn">
							Iniciar Sesión
						</button>
					</div>

					<!-- <div class="text-center p-t-12">
						<span class="txt1">
							Forgot
						</span>
						<a class="txt2" href="#">
							Username / Password?
						</a>
					</div> -->

					<div class="text-center p-t-136">
						<a class="txt2" href="https://iglesiaprimitivaperu.org">
							Ir a la página web
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<!-- <script src="vendor/jquery/jquery-3.2.1.min.js"></script> -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!--===============================================================================================-->
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
	<!-- <script src="vendor/bootstrap/js/popper.js"></script> -->
	<!-- <script src="vendor/bootstrap/js/bootstrap.min.js"></script> -->
<!--===============================================================================================-->
	<!-- <script src="vendor/select2/select2.min.js"></script> -->
<!--===============================================================================================-->
	<script src="{{ asset('plugins/tilt-login/tilt.jquery.min.js') }}"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="{{ asset('js/login/main.js') }}"></script>
    <script>
        $(function() {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            // $('.swalDefaultSuccess').click(function() {
            //     Toast.fire({
            //         icon: 'error',
            //         title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
            //     })
            // });

            var error = "{{ Session::get('msg')}}";
            var typealert = "{{ Session::get('typealert')}}";
            if(error){
                Toast.fire({
                    icon: typealert,
                    title: error
                })
            }            
            // icon: 'error',
            // title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
    </script>
</body>
</html>