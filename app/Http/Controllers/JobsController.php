<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use App\Models\JobType;
use App\Models\Category;
use App\Models\SavedJob;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use App\Mail\JobNotificationEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class JobsController extends Controller
{
    // this method will show jobs page
    public function index(Request $request){

        $categories = Category::where('status', 1)->get();
        $jobTypes = JobType::where('status', 1)->get();

        $jobs = Job::where('status', 1);

        // Search using keywords 
        if(!empty($request->keyword)){
            $jobs = $jobs->where(function($query) use($request){
                $query->orWhere('title', 'like', '%'.$request->keyword.'%');
                $query->orWhere('keywords', 'like', '%'.$request->keyword.'%');
            });
        }
        
        // Search by location 
        if(!empty($request->location)){
            $jobs = $jobs->where('location', $request->location);
        }

        // Search by category 
        if(!empty($request->category)){
            $jobs = $jobs->where('category_id', $request->category);
        }
        
        // Search using Job Type 
        $jobsTypeArray = [];
        if(!empty($request->jobType)){
            $jobsTypeArray = explode(',', $request->jobType);
            $jobs = $jobs->whereIn('job_type_id', $jobsTypeArray);
        }

        // Search using Experience 
        if($request->has('experience') && $request->experience !== ''){
            $jobs = $jobs->where('experience', $request->experience);
        }

        if($request->sort === '0'){
            $jobs = $jobs->orderBy('created_at', 'ASC');
        }else {
            $jobs = $jobs->orderBy('created_at', 'DESC');
        }

        $jobs = $jobs->paginate(9);

        return view('front.jobs', [
            'categories' => $categories,
            'jobTypes' => $jobTypes,
            'jobs' => $jobs,
            'jobTypeArray' => $jobsTypeArray
        ]);
    }

    // This method will show job detail page
    public function detail($id){
        $job = Job::where(['id'=> $id, 'status'=>1])->first();

        if($job == null){
            abort(404);
        }

        $count = 0;
        if(Auth::user()){
            $count = SavedJob::where(['user_id'=> Auth::user()->id, 'job_id'=> $id])->count();
        }

        // fetch applicants 
        $applications = JobApplication::where('job_id', $id)->get();

        return view('front.jobDetail', [
            'job' => $job,
            'count' => $count,
            'applications' => $applications
        ]);
    }

    public function applyJob(Request $request){
        $id = $request->id;

        $job = Job::where('id', $id)->first();

        // if job not found in db 
        if($job == null){
            $message = 'Job does not exist.';
            session()->flash('error',$message);
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }

        // you can not apply on your own job
        $employer_id = $job->user_id;

        if ($employer_id == Auth::user()->id) {
            $message = 'You can not apply on your own job.';
            session()->flash('error',$message);
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }
        
        // You can not apply on a job twise
        $jobApplicationCount = JobApplication::where([
            'user_id' => Auth::user()->id,
            'job_id' => $id
        ])->count();
        
        if ($jobApplicationCount > 0) {
            $message = 'You already applied on this job.';
            session()->flash('error',$message);
            return response()->json([
                'status' => false,
                'message' => $message
            ]);
        }

        $application = new JobApplication();
        $application->job_id = $id;
        $application->user_id = Auth::user()->id;
        $application->employer_id = $employer_id;
        $application->applied_date = now();
        $application->save();

        $mailData = [
            'user' => Auth::user(),
            'job' => $job
        ];
        Mail::to(Auth::user()->email)->send(new JobNotificationEmail($mailData));
        
        $message = 'You have successfully applied.';

        session()->flash('success',$message);

        return response()->json([
            'status' => true,
            'message' => $message
        ]);
    }

    public function saveJob(Request $request){
        $id = $request->id;
        $job = Job::find($id);
        if($job==null){
            session()->flash('error', 'Job not found');

            return response()->json([
                'status' => false,
            ]);
        }

        // Check if user already saved the job 
        $count = SavedJob::where([
            'user_id'=> Auth::user()->id,
            'job_id' => $id
        ])->count();


        if ($count > 0) {
            session()->flash('error','You already saved this job.');

            return response()->json([
                'status' => false,
            ]);
        }

        $savedJob = new SavedJob;
        $savedJob->job_id = $id;
        $savedJob->user_id = Auth::user()->id;
        $savedJob->save();

        session()->flash('success','Job saved successfully.');

        return response()->json([
            'status' => true,
        ]);

    }
}
