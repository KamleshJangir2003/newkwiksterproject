<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from codervent.com/rocker/demo/vertical/errors-coming-soon.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 10 May 2024 06:42:23 GMT -->
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
	<!-- loader-->
	<link href="{{asset('Agent/assets/css/pace.min.css')}}" rel="stylesheet"/>
	<script src="{{asset('Agent/assets/js/pace.min.js')}}"></script>
	<!-- Bootstrap CSS -->
	<link href="{{ asset('Agent/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('Agent/assets/css/bootstrap-extended.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
	<link href="{{ asset('Agent/assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('Agent/assets/css/icons.css') }}" rel="stylesheet">
	<title>Kwikster | Agent</title>
</head>

<body class="bg-login">
	<!-- wrapper -->
	<div class="wrapper">
		<div class="error-404 d-flex align-items-center justify-content-center">
			<div class="card shadow-none bg-transparent">
				<div class="card-body text-center">
					<h1 class="display-4 mt-5">We are Coming Soon!</h1>
					<p>We are currently working hard on this page.
						<br>We will update when it'll be live.</p>
					<div class="row">
						<div class="col-12 col-lg-12 mx-auto">
							<button type="button" class="btn btn-lg btn-success px-5" onclick="window.location.href='{{ route('agent_dashboard') }}'">
								<i class="bx bx-home mr-1"></i> Home
							</button>						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="bg-white p-3 fixed-bottom border-top shadow">
			<div class="d-flex align-items-center justify-content-between flex-wrap">
				<p class="mb-0">Copyright © 2024 Kwikster. All right reserved.</p>
			</div>
		</div>
	</div>
	<!-- end wrapper -->
	<!-- Bootstrap JS -->
	<script src="{{ asset('Agent/assets/js/bootstrap.bundle.min.js')}}"></script>
</body>


<!-- Mirrored from codervent.com/rocker/demo/vertical/errors-coming-soon.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 10 May 2024 06:42:23 GMT -->
</html>