@extends('front.layouts.app')

@section('main')
<div class="container my-4">
	<div class="row gutters">
		<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
			@include('front.account.sidebar')
		</div>
		<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
			@include('front.message')
			<form action="" method="post" id="userForm" name="userForm" class="card p-5">
				<div class="row gutters">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
						<h6 class="mb-2 text-primary">Personal Details</h6>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group my-2">
							<label class="form-label" for="fullName">Full Name</label>
							<input type="text" name="name" class="form-control" id="name" placeholder="Enter full name" value="{{ $user->name }}">
							<p></p>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group my-2">
							<label class="form-label" for="email">Email</label>
							<input type="email" name="email" class="form-control" id="email" placeholder="Enter email id" value="{{ $user->email }}">
							<p></p>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group my-2">
							<label class="form-label" for="mobile">Phone</label>
							<input type="text" name="mobile" class="form-control" id="mobile" placeholder="Enter mobile number" value="{{ $user->mobile }}">
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group my-2">
							<label class="form-label" for="designation">Designation</label>
							<input type="text" name="designation" class="form-control" id="designation" placeholder="Designation" value="{{ $user->designation }}">
						</div>
					</div>
				</div>
				<div class="row gutters">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
						<div class="text-right mt-4">
							<button type="submit" class="btn btn-primary py-2">Update</button>
						</div>
					</div>
				</div>
			</form>

			<form action="" method="post" id="changePasswordForm" name="changePasswordForm" class="card p-5">
				<div class="row gutters">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
						<h6 class="mb-2 text-primary">Change Password</h6>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group my-2">
							<label class="form-label" for="old_password">Old Password*</label>
							<input type="password" name="old_password" class="form-control" id="old_password" placeholder="Old password">
							<p></p>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group my-2">
							<label class="form-label" for="new_password">New Password</label>
							<input type="password" name="new_password" class="form-control" id="new_password" placeholder="New password">
							<p></p>
						</div>
					</div>
					<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<div class="form-group my-2">
							<label class="form-label" for="confirm_password">Confirm Password</label>
							<input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Confirm password">
							<p></p>
						</div>
					</div>
				</div>
				<div class="row gutters">
					<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
						<div class="text-right mt-4">
							<button type="submit" class="btn btn-primary py-2">Update</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection


@section('customJs')
	<script type="text/javascript">
		$("#userForm").submit(function(e){
			e.preventDefault();

			$.ajax({
				url: '{{ route("account.updateProfile") }}',
				type: 'put',
				dataType: 'json',
				data: $("#userForm").serializeArray(),
				success: function(response){
					if(response.status == true){
						["name", "email"].forEach(field => {
							toggleValidation(field, null); 
						});
						
						window.location.href="{{ route('account.profile') }}";
					}else{
						let errors = response.errors;
						toggleValidation("name", errors.name);
						toggleValidation("email", errors.email);
					}
				}
			})
		})
	
		$("#changePasswordForm").submit(function(e){
			e.preventDefault();

			$.ajax({
				url: '{{ route("account.changePassword") }}',
				type: 'post',
				dataType: 'json',
				data: $("#changePasswordForm").serializeArray(),
				success: function(response){
					if(response.status == true){
						["old_password", "new_password", "confirm_password"].forEach(field => {
							toggleValidation(field, null); 
						});
						window.location.href="{{ route('account.profile') }}";
					}else{
						let errors = response.errors;                    
						toggleValidation("old_password", errors.old_password);
						toggleValidation("new_password", errors.new_password);
						toggleValidation("confirm_password", errors.confirm_password);
					}
				}
			})
		})
	</script>
@endsection