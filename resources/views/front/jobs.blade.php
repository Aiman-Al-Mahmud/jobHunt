@extends('front.layouts.app')

@section('main')
<section class="section-3 py-5 bg-2 ">
    <div class="container">
        <div class="row">
            <div class="col-6 col-md-10 ">
                <h2>Find Jobs</h2>
            </div>
            <div class="col-6 col-md-2">
                <div class="align-end">
                    <select name="sort" id="sort" class="form-control">
                        <option value="1" {{ (Request::get('sort') == '1') ? 'selected' : ''}}>Latest</option>
                        <option value="0" {{ (Request::get('sort') == '0') ? 'selected' : ''}}>Oldest</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row pt-5">
            <div class="col-md-4 col-lg-3 sidebar mb-4">

                <form action="" name="searchForm" id="searchForm">
                <div class="card border-0 shadow p-4">
                    <div class="mb-4">
                        <h6>Keywords</h6>
                        <input value="{{ Request::get('keyword') }}"  type="text" name="keyword" id="keyword" placeholder="Keywords" class="form-control">
                    </div>

                    <div class="mb-4">
                        <h6>Location</h6>
                        <input value="{{ Request::get('location') }}" type="text" name="location" id="location" placeholder="Location" class="form-control">
                    </div>

                    <div class="mb-4">
                        <h6>Category</h6>
                        <select name="category" id="category" class="form-control bg-white">
                            <option value="">Select a Category</option>
                            @if($categories->isNotEmpty())
                                @foreach ($categories as $category)
                                    <option {{ (Request::get('category') == $category->id) ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="mb-4">
                        <h6>Job Type</h6>
                        @if($jobTypes->isNotEmpty())
                            @foreach ($jobTypes as $type)
                                <div class="form-check mb-2">
                                    <input {{ in_array($type->id, $jobTypeArray) ? 'checked': '' }} class="form-check-input" name="job_type" type="checkbox" value="{{ $type->id }}" id="job-type-{{ $type->id }}">
                                    <label class="form-check-label" for="job-type-{{ $type->id }}">{{ $type->name }}</label>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="mb-4">
                        <h6>Experience</h6>
                        <select name="experience" id="experience" class="form-control bg-white">
                            <option value="" {{ (Request::get('experience') == '') ? 'selected' : '' }} >Select experience</option>
                            <option value="0" {{ (Request::get('experience') == 0 && Request::get('experience') != null) ? 'selected' : '' }} >Fresher</option>
                            <option value="2" {{ (Request::get('experience') == 2) ? 'selected' : '' }} >0-2 Years</option>
                            <option value="4" {{ (Request::get('experience') == 4) ? 'selected' : '' }} >2-4 Years</option>
                            <option value="6" {{ (Request::get('experience') == 6) ? 'selected' : '' }} >4-6 Years</option>
                            <option value="8" {{ (Request::get('experience') == 8) ? 'selected' : '' }} >6-8 Years</option>
                            <option value="10" {{ (Request::get('experience') == 10) ? 'selected' : '' }} >8-10 Years</option>
                            <option value="10_plus" {{ (Request::get('experience') == '10_plus') ? 'selected' : '' }} >10+ Years</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary py-2">Search</button>
                    <a href="{{ route('jobs') }}" type="submit" class="btn btn-secondary mt-2 py-2">Reset Filters</a>
                    </form>
                </div>
            </div>


            <div class="col-md-8 col-lg-9 ">
                @if ($jobs->isNotEmpty())
                    @foreach ($jobs as $index => $job)
                        <div class="job-card  bg-white shadow mb-3 wow fadeInUp" data-wow-delay="{{ 0.3 + (0.2 * $index) }}s">
                            <div class="job-card-header">
                                <img src="{{ $job->company_website }}/favicon.ico"
                                    onerror="this.onerror=null; this.src='{{ $job->company_website }}/favicon.png'"
                                    alt="job" />
                                <div>
                                    <h4 class="my-0">{{ $job->company_name }}</h4>
                                    <span>{{ $job->location }}</span>
                                </div>
                            </div>
                                <a href="{{ route('jobDetail', $job->id) }}" >
                                    <h4>{{ $job->title }}</h4>
                                    <p>{{ Str::words(strip_tags($job->description), 35) }}</p>
                                </a>
                                <div class="job-card-footer">
                                @if ($job->vacancy)
                                    <span>{{ $job->vacancy }} Vacancy</span>
                                @endif
                                <span>{{ $job->jobType->name }}</span>
                                @if ($job->salary)
                                    <span>{{ $job->salary }}</span> 
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-center">No jobs found</p>
                @endif
            </div>
        </div>
</section>
@endsection


@section('customJs')
    <script>
        $("#searchForm").submit(function(e){
            e.preventDefault();

            let url = '{{ route("jobs") }}?';

            let keyword = $('#keyword').val();
            let location = $('#location').val();
            let category = $('#category').val();
            let experience = $('#experience').val();
            let sort = $('#sort').val();

            let checkedJobTypes = $("input:checkbox[name='job_type']:checked").map(function(){
                return $(this).val();
            }).get();

            // if keyword has a value 
            if( keyword != ""){
                url += '&keyword='+keyword;
            }

            // if location has a value 
            if( location != ""){
                url += '&location='+location;
            }

            // if category has a value 
            if( category != ""){
                url += '&category='+category;
            }

            // if experience has a value 
            if( experience != ""){
                url += '&experience='+experience;
            }

            // if user has a checked job types 
            if( checkedJobTypes.length > 0){
                url += '&jobType='+checkedJobTypes;
            }

            url += '&sort='+sort;

            window.location.href=url;
        });

        $('#sort').change(function(){
            $("#searchForm").submit();
        });

    </script>
@endsection