@extends('front.layouts.app')

@section('main')
<section class="sign-in">

    @if (Session::has('success'))
        <div class="alert alert-success">
            <p>{{ Session::get('success') }}</p>
        </div>
    @endif
    
    @if (Session::has('error'))
        <div class="alert alert-danger">
            <p>{{ Session::get('error') }}</p>
        </div>
    @endif

    <form action="{{ route('account.authenticate') }}" method="post">
        @csrf
        <h1 class="mb-4">Sign-in</h1>
        <div class="mb-3">
            <label class="form-label" for="email">Email</label>
            <input type="email" value="{{ old('email') }}" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="Email">
            @error('email')
                <p class="invalid-feedback">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label class="form-label" for="password">Password </label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror " id="password" placeholder="Password" autocomplete="current-password">
            @error('password')
                <p class="invalid-feedback">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <button class="btn btn-primary w-100">Sign In</button>
        </div>
        <div class="mt-4 text-center">
            <p>Don't have an account? <a href="{{ route('account.registration') }}">Sign Up</a> </p>
        </div>
    </form>
</section>
@endsection