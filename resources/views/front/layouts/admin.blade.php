@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <!-- Admin sidebar -->
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Users</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Job Posts</a>
                </li>
                <!-- Add more admin navigation items here -->
            </ul>
        </div>
        <div class="col-md-10">
            @yield('admin-content')
        </div>
    </div>
</div>
@endsection