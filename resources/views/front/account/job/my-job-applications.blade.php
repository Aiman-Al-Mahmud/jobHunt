@extends('front.layouts.app')

@section('main')
<div class="container my-4">
	<div class="row gutters">
		<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
			@include('front.account.sidebar')
		</div>
		<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
			@include('front.message')
            <div class="card border-0 mb-4 p-3">
                <div class="card-body card-form">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h3 class="fs-4 mb-0">Jobs Applied</h3>
                        </div>
                        <div>
                            <a href="{{ route("jobs") }}" class="btn btn-primary py-2">Browse Jobs</a>
                        </div>    
                    </div>
                    @if ($jobApplications->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg-light text-primary">
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Applied Date</th>
                                    <th scope="col">Applicants</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="border">
                                @if ($jobApplications->isNotEmpty())
                                    @foreach ($jobApplications as $jobApplication)
                                    <tr class="active">
                                        <td>
                                            <div class="job-name">{{ $jobApplication->job->title }}</div>
                                            <div class="info1">{{ $jobApplication->job->jobType->name }} | {{ $jobApplication->job->location }}</div>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($jobApplication->applied_date)->format('d M, Y') }}</td>
                                        <td>{{ $jobApplication->job->applications->count() }} Applicants</td>
                                        <td>
                                            @if ($jobApplication->job->status == 1)
                                            <div class="job-status text-capitalize">Active</div>
                                            @else
                                            <div class="job-status text-capitalize">Block</div>
                                            @endif                                    
                                        </td>
                                        <td>
                                            <div role="button" class="action-dots hand float-end">
                                                <div data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v text-primary px-2" aria-hidden="true"></i>
                                                </div>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="{{ route("jobDetail", $jobApplication->job_id) }}"><i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="removeJobs({{ $jobApplication->id }})" ><i class="fa fa-trash" aria-hidden="true"></i> Remove</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif 
                            </tbody>                                
                        </table>
                        @else
                            <p>You have not applied to any jobs.</p>
                        @endif
                    </div>
                    <div>
                        {{ $jobApplications->links() }}
                    </div>
                </div>
            </div>   
		</div>
	</div>
</div>
@endsection


@section('customJs')
    <script type="text/javascript">
        function removeJobs(jobId){
            if(confirm("Are you sure you want to remove this application?")){
                $.ajax({
                    url: '{{ route('account.removeJobs') }}',
                    type: 'delete',
                    data: {id: jobId},
                    dataType: 'json',
                    success: function(response) {
                        window.location.href='{{ route("account.myJobApplications") }}';
                    }
                })
            }
        }
    </script>
@endsection