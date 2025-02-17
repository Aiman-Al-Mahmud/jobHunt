@extends('front.layouts.app')

@section('main')
<div class="container-xxl pt-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <div class="mb-5">
            <a href="{{ route('jobs') }}"><i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp;Back to Jobs</a>
        </div>
        <div class="row mb-5 gy-5 gx-4 bg-white rounded p-3">
            <div class="col-lg-8">
                @include('front.message')
                <div class="d-flex align-items-center mb-5">
                    <img class="flex-shrink-0 img-fluid border rounded" src="{{ $job->company_website }}/favicon.ico"
                        onerror="this.onerror=null; this.src='{{ $job->company_website }}/favicon.png'" alt="job"
                        width="80" />
                    <div class="text-start ps-4">
                        <h3 class="mb-3">{{ $job->title }}</h3>
                        <span class="text-truncate me-3"><i class="fa fa-map-marker-alt text-primary me-2"></i>{{ $job->location }}</span>
                        <span class="text-truncate me-3"><i class="far fa-clock text-primary me-2"></i>{{ $job->jobType->name }}</span>
                        <span class="text-truncate me-0"><i class="far fa-money-bill-alt text-primary me-2"></i>{{ $job->salary }}</span>
                    </div>
                    <div class="jobs_right" style="margin:0 0 auto auto ;">
                        <div class="save_job">
                            <a href="javascript:void(0);" onclick="saveJob({{ $job->id }})" class="btn btn-light btn-square" aria-hidden="true"><i class="{{ ($count == 1)?'fas': 'far'}} fa-heart"></i></a>
                        </div>
                    </div>
                </div>

                <div class="mb-5 job-detail">
                    <h4 class="mb-3">Job description</h4>
                    <p>{!! nl2br($job->description) !!}</p>
                    <h4 class="mb-3">Responsibility</h4>
                    <p>{!! nl2br($job->responsibility) !!}</p>
                    <h4 class="mb-3">Qualifications</h4>
                    <p>{!! nl2br($job->qualification) !!}</p </div>
                </div>

                <div>       
                    @if (Auth::check())
                        <a href="#" onclick="saveJob({{ $job->id }})" class="btn btn-secondary me-2">Save</a>  
                    @else
                        <a href="javascript:void(0);" class="btn btn-secondary me-2 disabled">Login to Save</a>
                    @endif

                    @if (Auth::check())
                        <a href="#" onclick="applyJob({{ $job->id }})" class="btn btn-primary">Apply</a>
                    @else
                        <a href="javascript:void(0);" class="btn btn-primary disabled text-white">Login to Apply</a>
                    @endif
                </div>

                @if (Auth::user() && Auth::user()->id == $job->user_id)
                    <div class="applicants mt-5">
                        <div class="">
                            <h3 class="mb-3">Applicants</h3>
                        </div>
                        <div class="table-responsive">
                            <table class="table border">
                                <thead class="bg-light text-primary">
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Applied Date</th>
                                </thead>
                                <tbody>
                                    @if ($applications->isNotEmpty())
                                        @foreach ($applications as $application)
                                            <tr>
                                                <td>{{ $application->user->name }}</td>
                                                <td>{{ $application->user->email }}</td>
                                                <td>{{ $application->user->mobile }}</td>
                                                <td>{{ \Carbon\Carbon::parse($application->applied_date)->format('d M, Y') }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr><td colspan="4">No Applicants</td></tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
            
            <div class="col-lg-4">
                <div class="bg-light rounded p-5 mb-4 wow slideInUp" data-wow-delay="0.1s">
                    <h4 class="mb-4">Job Summary</h4>
                    <p><i class="fa fa-angle-right text-primary me-2"></i>Published On: {{ \Carbon\Carbon::parse($job->create_at)->format('d M, Y') }}</p>
                    <p><i class="fa fa-angle-right text-primary me-2"></i>Vacancy: {{ $job->vacancy }} Position</p>
                    <p><i class="fa fa-angle-right text-primary me-2"></i>Job Nature: {{ $job->jobType->name }}</p>
                    <p><i class="fa fa-angle-right text-primary me-2"></i>Salary: {{ $job->salary }}</p>
                    <p class="m-0"><i class="fa fa-angle-right text-primary me-2"></i>Location: {{ $job->location }}</p>
                </div>
                <div class="bg-light rounded p-5 wow slideInUp" data-wow-delay="0.1s">
                    <h4 class="mb-4">Company Details</h4>
                    <p><i class="fa fa-angle-right text-primary me-2"></i>Name: {{ $job->company_name }}</p>
                    <p><i class="fa fa-angle-right text-primary me-2"></i>Location: {{ $job->company_location }}</p>
                    <p><i class="fa fa-angle-right text-primary me-2"></i>Website: <a href="{{ $job->company_website }}" rel="noreferrer" target="_blank">{{ $job->company_website }}</a></p>
                </div>
            </div>
        </div>
    </div>
    @endsection


    @section('customJs')
        <script type="text/javascript">
            function applyJob(id){
                if(confirm("Are you sure you want to apply on this job")){
                    $.ajax({
                        url : '{{ route("applyJob") }}',
                        type: 'post',
                        data: {id:id},
                        dataType: 'json',
                        success: function(response) {
                            window.location.href = "{{ url()->current() }}";
                        } 
                    });
                }
            }

            function saveJob(id){
                $.ajax({
                    url : '{{ route("saveJob") }}',
                    type: 'post',
                    data: {id:id},
                    dataType: 'json',
                    success: function(response) {
                        window.location.href = "{{ url()->current() }}";
                    } 
                });
            }
        </script>
    @endsection