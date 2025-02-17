@extends('front.layouts.app')

@section('main')


<!-- Home Start -->
<section class="container-fluid my-5 section-container header-container" id="home">
    <img src="assets/google.png" alt="header" />
    <img src="assets/twitter.png" alt="header" />
    <img src="assets/amazon.png" alt="header" />
    <img src="assets/figma.png" alt="header" />
    <img src="assets/linkedin.png" alt="header" />
    <img src="assets/microsoft.png" alt="header" />
    <h2>
        <img src="assets/bag.png" alt="bag" /> No.1 Job Hunt Website
    </h2>
    <h1>Search, Apply &<br />Get Your <span>Dream Job</span></h1>
    <p>
        Your future starts here. Discover countless opportunities, take action
        by applying to jobs that match your skills and aspirations, and
        transform your career.
    </p>
    <div class="header-btns">
        <a href="{{ route('jobs') }}" class="btn btn-primary text-white">Browse Jobs</a>
        <a href="#">
            <span><i class="bi bi-play-fill"></i></span>
            How It Works?
        </a>
    </div>
</section>
<!-- Home End -->


<!-- Search Form Start -->
<div class="container-fluid search mb-5 p-4 wow fadeIn" data-wow-delay="0.1s">
    <div class="container">
        <form action="{{ route("jobs") }}" method="GET">
        <div class="row g-2">
            <div class="col-md-10">
                <div class="row g-2">
                    <div class="col-md-4">
                        <input type="text" name="keyword" id="keyword" class="form-control border-0" placeholder="Keywords" />
                    </div>
                    <div class="col-md-4">
                        <select name="category" id="category" class="form-control bg-white border-0 ">
                            <option value="" selected >Select Category</option>
                            @if ($categories->isNotEmpty())
                                @foreach ($categories->take(8) as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="text" name="location" id="location" class="form-control border-0" placeholder="Location" />
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary py-2 w-100">Search</button>
            </div>
        </form>
        </div>
    </div>
</div>
<!-- Search End -->


<!-- Category Start -->
<div class="container-xxl py-5">
    <div class="container">
        <h1 class="text-center mb-3 heading wow fadeInUp" style="max-width:900px; margin:auto;" data-wow-delay="0.1s"><span>Countless Career Options</span> Are Waiting For You To Explore </h1>
        <p class="text-center wow fadeInUp mb-5" data-wow-delay="0.1s">Discover a World of Exciting Opportunities and Endless Possibilities, and Find the Perfect Career Path to Shape Your Future. </p>

        <div class="row g-4">
            @if ($categories->isNotEmpty())
                @foreach ($categories->take(8) as $category)
                <div class="col-lg-3 col-sm-6 wow fadeInUp" data-wow-delay="0.3s">
                    <a class="cat-item rounded p-4" href="{{ route('jobs').'?category='.$category->id }}">
                        <h1 class="fs-4 text-primary">{{ $category->name }}</h1>
                        <p class="my-0 info1 fs-6">123 Vacancy</p>
                    </a>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
<!-- Category End -->


<!-- About Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                <div class="row g-0 about-bg rounded overflow-hidden">
                    <div class="col-6 text-start">
                        <img class="img-fluid w-100" src="assets/about-1.jpg">
                    </div>
                    <div class="col-6 text-start">
                        <img class="img-fluid" src="assets/about-2.jpg" style="width: 85%; margin-top: 15%;">
                    </div>
                    <div class="col-6 text-end">
                        <img class="img-fluid" src="assets/about-3.jpg" style="width: 85%;">
                    </div>
                    <div class="col-6 text-end">
                        <img class="img-fluid w-100" src="assets/about-4.jpg">
                    </div>
                </div>
            </div>
            <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                <h1 class="mb-4">Unlock Your Dream Job & Discover Top Talent</h1>
                <p class="mb-4">Finding the right job or the perfect candidate has never been easier. Whether you're seeking a career that aligns with your passion or searching for skilled professionals to drive your business forward, we've got you covered.</p>
                <p><i class="fa fa-check text-primary me-3"></i>Find the best job opportunities that match your skills.</p>
                <p><i class="fa fa-check text-primary me-3"></i>Connect with top employers and industry leaders.</p>
                <p><i class="fa fa-check text-primary me-3"></i>Take the next step toward career success today!</p>
                <a class="btn btn-primary py-3 px-5 mt-3" href="">Read More</a>
            </div>
        </div>
    </div>
</div>
<!-- About End -->


<!-- Jobs Start -->
<div class="container-xxl py-5">
    <div class="container">
        <h1 class="text-center heading mb-3 wow fadeInUp" data-wow-delay="0.1s"><span>Latest & Top</span> Job Openings</h1>
        <p class="text-center wow fadeInUp mb-5" data-wow-delay="0.1s">Discover Exciting New Opportunities and High-Demand Positions Available Now in Top Industries and Companies </p>
        <div class="job-grid">
            @if ($latestJobs->isNotEmpty())
                @foreach ($latestJobs as $index => $job)
                <div class="job-card wow fadeInUp" data-wow-delay="{{ 0.1 + (0.2 * $index) }}s">
                    <div class="job-card-header">
                        <img src="{{ $job->company_website }}/favicon.ico" onerror="this.onerror=null; this.src='{{ $job->company_website }}/favicon.png'" alt="job" />
                        <div>
                            <h4 class="my-0">{{ $job->company_name }}</h4>
                            <span>{{ $job->location }}</span>
                        </div>
                    </div>
                    <a href="{{ route('jobDetail', $job->id) }}" >
                        <h4>{{ $job->title }}</h4>
                        <p>{{ Str::words(strip_tags($job->description), 20) }}</p>
                    </a>
                    <div class="job-card-footer">
                        <span>{{ $job->vacancy }} Positions</span>
                        <span>{{ $job->jobType->name }}</span>
                        <span>{{ $job->salary }}</span>
                    </div>
                </div>
                @endforeach
            @endif
        </div>

    </div>
</div>
<!-- Jobs End -->


<!-- Testimonial Start -->
<div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s">
    <div class="container">
        <h1 class="text-center heading mb-5">What Our <span>Clients Say</span> </h1>
        <div class="owl-carousel testimonial-carousel">
            <div class="testimonial-item bg-light rounded p-4">
                <i class="fa fa-quote-left fa-2x text-primary mb-3"></i>
                <p>Creating an account was a breeze, and I was amazed by the number of job opportunities available.
                    Thanks to this website, I foundthe perfect position that aligned perfectly with my careergoals.
                </p>
                <div class="d-flex align-items-center">
                    <img class="img-fluid flex-shrink-0 rounded" src="assets/testimonial-1.jpg"
                        style="width: 50px; height: 50px;">
                    <div class="ps-3">
                        <h5 class="mb-1">Aiman AL Mahmud</h5>
                        <small>Software Engineer</small>
                    </div>
                </div>
            </div>
            <div class="testimonial-item bg-light rounded p-4">
                <i class="fa fa-quote-left fa-2x text-primary mb-3"></i>
                <p>
                    As a recent graduate, I was unsure where to start my job search.
                    This website guided me through the process step by step. From
                    creating my profile to receiving job offers, everything was
                    seamless. I'm now happily employed thanks to this platform!
                </p>
                <div class="d-flex align-items-center">
                    <img class="img-fluid flex-shrink-0 rounded" src="assets/testimonial-2.jpg"
                        style="width: 50px; height: 50px;">
                    <div class="ps-3">
                        <h5 class="mb-1">MR.Rahman</h5>
                        <small>Recent Graduate</small>
                    </div>
                </div>
            </div>
            <div class="testimonial-item bg-light rounded p-4">
                <i class="fa fa-quote-left fa-2x text-primary mb-3"></i>
                <p>
                    Searching for a job can be overwhelming, but this platform made
                    it simple and efficient. I uploaded my resume, applied to a few
                    positions, and soon enough, I was hired! Thank you for helping
                    me kickstart my career!
                </p>
                <div class="d-flex align-items-center">
                    <img class="img-fluid flex-shrink-0 rounded" src="assets/testimonial-3.jpg"
                        style="width: 50px; height: 50px;">
                    <div class="ps-3">
                        <h5 class="mb-1">Sarah khan</h5>
                        <small>Graphic Designer</small>
                    </div>
                </div>
            </div>
            <div class="testimonial-item bg-light rounded p-4">
                <i class="fa fa-quote-left fa-2x text-primary mb-3"></i>
                <p>
                    Searching for a job can be overwhelming, but this platform made
                    it simple and efficient. I uploaded my resume, applied to a few
                    positions, and soon enough, I was hired! Thank you for helping
                    me kickstart my career!
                </p>
                <div class="d-flex align-items-center">
                    <img class="img-fluid flex-shrink-0 rounded" src="assets/testimonial-4.jpg"
                        style="width: 50px; height: 50px;">
                    <div class="ps-3">
                        <h5 class="mb-1">Mehnaz Ahhmmed</h5>
                        <small>Web Developer</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Testimonial End -->

@endsection