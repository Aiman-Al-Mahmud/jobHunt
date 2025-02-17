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
                            <h3 class="fs-4 mb-0">Saved Jobs</h3>
                        </div>
                        <div>
                            <a href="{{ route("jobs") }}" class="btn btn-primary py-2">Browse Jobs</a>
                        </div>    
                    </div>
                    @if ($savedJobs->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg-light text-primary">
                                <tr>
                                    <th scope="col">Title</th>
                                    <th scope="col">Applicants</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="border">
                                @if ($savedJobs->isNotEmpty())
                                    @foreach ($savedJobs as $savedJob)
                                    <tr class="active">
                                        <td>
                                            <div class="job-name">{{ $savedJob->job->title }}</div>
                                            <div class="info1">{{ $savedJob->job->jobType->name }} | {{ $savedJob->job->location }}</div>
                                        </td>
                                        <td>{{ $savedJob->job->applications->count() }} Applicants</td>
                                        <td>
                                            @if ($savedJob->job->status == 1)
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
                                                    <li><a class="dropdown-item" href="{{ route("jobDetail", $savedJob->job_id) }}"><i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                                    <li><a class="dropdown-item" href="#" onclick="removeSavedJob({{ $savedJob->id }})" ><i class="fa fa-trash" aria-hidden="true"></i> Remove</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif 
                            </tbody>                                
                        </table>
                        @else
                            <p>You have not saved any jobs.</p>
                        @endif
                    </div>
                    <div>
                        {{ $savedJobs->links() }}
                    </div>
                </div>
            </div>   
		</div>
	</div>
</div>
@endsection


@section('customJs')
    <script type="text/javascript">
        function removeSavedJob(jobId){
            $.ajax({
                url: '{{ route('account.removeSavedJob') }}',
                type: 'delete',
                data: {id: jobId},
                dataType: 'json',
                success: function(response) {
                    window.location.href='{{ route("account.savedJobs") }}';
                }
            })
        }
    </script>
@endsection