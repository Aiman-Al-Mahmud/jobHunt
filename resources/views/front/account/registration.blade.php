@extends('front.layouts.app')

@section('main')
<section class="sign-up">
    <form action="" name="registrationForm" id="registrationForm">
        <h1 class="mb-4">Sign Up</h1>
        <div class="mb-3">
            <label class="form-label" for="name">Name</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Name">
            <p></p>
        </div>
        <div class="mb-3">
            <label class="form-label" for="email">Email</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="Email">
            <p></p>
        </div>
        <div class="mb-3">
            <label class="form-label" for="password">Password </label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Password" autocomplete="current-password">
            <p></p>
        </div>
        <div class="mb-4">
            <label class="form-label" for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Confirm Password">
            <p></p>
        </div>

        <div>
            <button class="btn btn-primary w-100">Sign Up</button>
        </div>
    </form>
    <div class="mt-4 text-center">
        <p>Already have an account? <a href="{{ route('account.login') }}">Sign in</a> </p>
    </div>
</section>
@endsection

@section('customJs')
<script>
    $("#registrationForm").submit(function(e){
        e.preventDefault();

        $.ajax({
            url: '{{ route("account.processRegistration") }}',
            type: 'post',
            data: $("#registrationForm").serializeArray(),
            dataType: 'json',
            success: function(response){
                if(response.status == false){
                    let errors = response.errors;
                    if(errors.name){
                        $("#name").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.name)
                    }else{
                        $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('')
                    }
                    if(errors.email){
                        $("#email").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.email)
                    }else{
                        $("#email").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('')
                    }
                    if(errors.password){
                        $("#password").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.password)
                    }else{
                        $("#password").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('')
                    }
                    if(errors.confirm_password){
                        $("#confirm_password").addClass('is-invalid').siblings('p').addClass('invalid-feedback').html(errors.confirm_password)
                    }else{
                        $("#confirm_password").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('')
                    }
                }
                else{
                    $("#name").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('')
                    $("#email").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('')
                    $("#password").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('')
                    $("#confirm_password").removeClass('is-invalid').siblings('p').removeClass('invalid-feedback').html('')
                    window.location.href='{{ route("account.login") }}';
                }
            }
        })
    })

</script>
@endsection