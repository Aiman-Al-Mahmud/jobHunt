<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>JobHunt</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<meta content="" name="keywords">
	<meta content="" name="description">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- Google Web Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap" rel="stylesheet">

	<!-- Icon Font Stylesheet -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

	<!-- Libraries Stylesheet -->
	<link href=" {{ asset('lib/animate/animate.min.css') }}" rel="stylesheet">
	<link href=" {{ asset('lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

	<!-- Customized Stylesheet -->
	<link type="text/css" href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
	<link type="text/css" href="{{ asset('css/style.css') }}" rel="stylesheet">

</head>

<body>
	<main class="container-xxl p-0">

		<!-- Spinner  -->
		<div id="spinner"
			class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
			<div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
				<span class="sr-only">Loading...</span>
			</div>
		</div>


		<!-- Navbar -->
		<nav class="navbar navbar-expand-lg navbar-light sticky-top p-0">
			<a href="{{ route('home') }}" class="navbar-brand d-flex align-items-center text-center py-0 px-4 px-lg-5">
				<h1 class="m-0 logo text-primary">Job<span>Hunt</span></h1>
			</a>
			<button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarCollapse">
				<div class="navbar-nav ms-auto p-4 p-lg-0">
					<a href="{{ route('home') }}" class="nav-item nav-link">Home</a>
					<a href="" class="nav-item nav-link">About</a>
					<a href="{{ route('jobs') }}" class="nav-item nav-link">Jobs</a>
					<a href="" class="nav-item nav-link">Contact</a>
					<a href="{{ route('account.createJob') }}" class="nav-item nav-link">Post a job</a>

				</div>
				@if (Auth::check())
					<a href="{{ route('account.profile') }}" class="nav-item nav-link" title="My profile"><i class="bi bi-person-circle fs-2"></i></i></a>
				@else
					<a href="{{ route('account.login') }}" class="btn btn-primary rounded-0 py-4 px-lg-5 d-none d-lg-block">Sign In<i class="fa fa-arrow-right ms-3"></i></a>
				@endif
			</div>
		</nav>

		@yield('main')

		<!-- Footer  -->
		<footer class="footer container-fluid mt-5 border-top">
			<div class="row py-5 my-5 ">
				<div class="col-4">
					<h3 class="mb-3 logo text-primary">Job<span>Hunt</span></h3>
					<p class="text-body-secondary">Our platform is designed to help you find the perfect job and achieve your professional dreams. </p>
				</div>

				<div class="col">
					<h5 class="mb-4">Quick Links</h5>
					<ul class="nav gap-3 flex-column">
						<li><a href="#">Home</a></li>
						<li><a href="#">About</a></li>
						<li><a href="#">Jobs</a></li>
						<li><a href="#">Contact</a></li>
						<li><a href="{{ route('account.createJob') }}">Post a job</a></li>
					</ul>
				</div>

				<div class="col">
					<h5 class="mb-4">Follow us</h5>
					<ul class="nav flex-column gap-3">
						<li><a href="https://www.facebook.com/aimanmahmud69">Facebook</a></li>
						<li><a href="https://github.com/Aiman-Al-Mahmud">Github</a></li>
						<li><a href="https://www.linkedin.com/in/aiman-al-mahmud-a7b333332/">LinkedIn</a></li>
						<li><a href="https://x.com">Twitter</a></li>
					</ul>
				</div>

				<div class="col">
					<h5 class="mb-4">Contact Us</h5>
					<ul class="nav flex-column gap-3">
						<li><a href="tel:+8801787755330"> <i class="bi bi-telephone-fill"></i> +8801787755330 </a></li>
						<li><a href=""> <i class="bi bi-geo-alt-fill"></i> KHULNA,BANGLADESH</a></li>
					</ul>
				</div>
			</div>

			<div class="text-center p-3 bg-light">
				© 2024 Copyright | Built by
				<a class="text-primary" href="https://github.com/ADi7YA26" no-referrer>Aditya</a>
			</div>
		</footer>
	</main>

	<!-- JavaScript Libraries -->
	<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/classic/ckeditor.js"></script>
	<script src="{{ asset('lib/wow/wow.min.js') }}"></script>
	<script src="{{ asset('lib/easing/easing.min.js') }}"></script>
	<script src="{{ asset('lib/waypoints/waypoints.min.js') }}"></script>
	<script src="{{ asset('lib/owlcarousel/owl.carousel.min.js') }}"></script>

	<script src="{{ asset('js/main.js') }}"></script>
	<script src="{{ asset('js/utils.js') }}"></script>

	<script>
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$("#profilePicForm").submit(function(e){
			e.preventDefault();
			let formData = new FormData(this);
			$('#spinner').addClass('show');
			$.ajax({
				url: '{{ route("account.updateProfilePic") }}',
				type: 'post',
				dataType: 'json',
				data: formData,
				contentType: false,
				processData: false,
				success: function(response){
					$('#spinner').removeClass('show');
					if(response.status == false){
						let errors =response.errors;
						if(errors.image){
							$('#image-error').html(errors.image)
						}
					}else{
						window.location.href = '{{ url()->current() }}';
					}
				}
			})
		})
	</script>
	@yield('customJs')
</body>

</html>