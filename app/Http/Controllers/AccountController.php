<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\User;
use App\Models\JobType;
use App\Models\Category;
use App\Models\SavedJob;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class AccountController extends Controller
{
    // This method will show user registration page
    public function registration(){
        return view('front.account.registration');
    }

    // This method will save a user
    public function processRegistration(Request $request){
        // Validate user input
        $request->validate([
            'name'             => 'required',
            'email'            => 'required|email|unique:users,email',
            'password'         => 'required|min:5',
            'confirm_password' => 'required|same:password',
        ]);
   
        // Create the user with the hashed password, setting is_admin for the specified email.
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password), // Hash the password
            'is_admin' => $request->email === 'aimanmahmaud69@gmail.com', // Set as admin if the email matches
        ]);
   
        session()->flash('success', 'You have registered successfully.');
   
        return redirect()->route('home')->with('success', 'Registration successful.');
    }
   
    
    // This method will show user login page
    public function login(){
        return view('front.account.login');
    }

    public function authenticate(Request $request)
    {
        // Get the credentials from the request
        $credentials = $request->only('email', 'password');
    
        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            // Authentication passed, get the authenticated user
            $user = Auth::user();
    
            // Check if the user is an admin
            if ($user->is_admin) {
                // Redirect admin user to the admin dashboard
                return redirect()->route('admin.dashboard');
            }
    
            // If the user is not an admin, redirect them to their profile or home
            return redirect()->route('account.profile');
        }
    
        // Authentication failed: redirect back with error
        return redirect()->back()->withErrors(['Invalid credentials. Please try again.']);
    }
    

    public function profile(){
        $id = Auth::user()->id;

        // $user = User::where('id', $id)->first();
        $user = User::find($id);


        return view('front.account.profile', [
            'user' => $user
        ]);
    }

    

    public function updateProfile(Request $request){
        $id = Auth::user()->id;

        $validator = Validator::make($request->all(),[
            'name' => 'required|min:5|max:20',
            'email' => 'required|email|unique:users,email,'.$id.',id'
        ]);

        if($validator->passes()){
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->designation = $request->designation;
            $user->save();

            session()->flash('success', 'Profile updated successfully');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    
    public function logout(){
        Auth::logout();
        return redirect()->route('account.login');
    }

    public function updateProfilePic(Request $request){
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg|max:1024'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }

        try {
            $image = $request->file('image');
            
            // Delet old image if exist
            if ($user->image) {
                $oldImageUrl = $user->image;
                $publicId = substr($oldImageUrl, strrpos($oldImageUrl, '/') + 1);
                $publicId = pathinfo($publicId, PATHINFO_FILENAME);
                $publicId = 'jobhunt/profile/' . $publicId;
        
                Cloudinary::destroy($publicId);
            }

            // Upload the new image to Cloudinary
            $uploadedFileUrl = Cloudinary::upload($image->getRealPath(), [
                'folder' => 'jobhunt/profile',
                'transformation' => [
                    'width' => 400,
                    'height' => 400,
                    'crop' => 'fill'
                ]
            ])->getSecurePath();

            // Update the user's profile with the new image URL
            $user->image = $uploadedFileUrl;
            $user->save();

            // Success response
            session()->flash('success', 'Profile picture updated successfully.');
            return response()->json([
                'status' => true,
                'errors' => [],
            ]);
            
        } catch (\Exception $e) {
            // Catch any errors (e.g., Cloudinary upload failure)
            return response()->json([
                'status' => false,
                'errors' => ['image' => 'Failed to upload the image. Please try again later.'],
            ]);
        }
    }

    public function createJob(){
        $categories = Category::orderBy('name', 'ASC')->where('status', 1)->get();
        $jobTypes = JobType::orderBy('name', 'ASC')->where('status', 1)->get();
        return view('front.account.job.create', [
            'categories' => $categories,
            'jobTypes' => $jobTypes
        ]);
    }

    public function saveJob(Request $request){

        $rules = [
            'title' => 'required|min:5|max:100',
            'category' => 'required',
            'job_type' => 'required',
            'vacancy' => 'nullable|integer',
            'location' => 'required|max:50',
            'description' => 'required',
            'company_name' => 'required|min:3|max:50',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->passes()){

            $job = new Job();
            $job->title = $request->title;
            $job->category_id = $request->category;
            $job->job_type_id  = $request->job_type;
            $job->user_id = Auth::user()->id;
            $job->vacancy = $request->vacancy;
            $job->salary = $request->salary;
            $job->location = $request->location;
            $job->description = $request->description;
            $job->benefits = $request->benefits;
            $job->responsibility = $request->responsibility;
            $job->qualification = $request->qualification;
            $job->keywords = $request->keywords;
            $job->experience = $request->experience;
            $job->company_name = $request->company_name;
            $job->company_location = $request->company_location;
            $job->company_website = $request->company_website;
            $job->save();

            session()->flash('success','Job added successfully.');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);

        }else{
            return response()->json([
                'status'=> false,
                'errors'=> $validator->errors(),
            ]);
        }
    }

    public function myJobs(){
        $jobs = Job::where('user_id', Auth::user()->id)->with('jobType')->orderBy('created_at', 'DESC')->paginate(10);
        return view('front.account.job.my-jobs', [
            'jobs' => $jobs
        ]);
    }

    public function editJob(Request $request, $id){
        $categories = Category::orderBy('name', 'ASC')->where('status', 1)->get();
        $jobTypes = JobType::orderBy('name', 'ASC')->where('status', 1)->get();
        $job = Job::where([
            'user_id' => Auth::user()->id,
            'id' => $id
        ])->first();

        if($job == null){
            abort(404);
        }

        return view('front.account.job.edit', [
            'categories' => $categories,
            'jobTypes' => $jobTypes,
            'job' => $job
        ]);
    }

    public function updateJob(Request $request, $id){

        $rules = [
            'title' => 'required|min:5|max:100',
            'category' => 'required',
            'job_type' => 'required',
            'vacancy' => 'nullable|integer',
            'location' => 'required|max:50',
            'description' => 'required',
            'company_name' => 'required|min:3|max:50',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->passes()){

            $job = Job::find($id);
            $job->title = $request->title;
            $job->category_id = $request->category;
            $job->job_type_id  = $request->job_type;
            $job->user_id = Auth::user()->id;
            $job->vacancy = $request->vacancy;
            $job->salary = $request->salary;
            $job->location = $request->location;
            $job->description = $request->description;
            $job->benefits = $request->benefits;
            $job->responsibility = $request->responsibility;
            $job->qualification = $request->qualification;
            $job->keywords = $request->keywords;
            $job->experience = $request->experience;
            $job->company_name = $request->company_name;
            $job->company_location = $request->company_location;
            $job->company_website = $request->company_website;
            $job->save();

            session()->flash('success','Job updated successfully.');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);

        }else{
            return response()->json([
                'status'=> false,
                'errors'=> $validator->errors(),
            ]);
        }
    }

    public function deleteJob(Request $request){
        
        $job = Job::where([
            'user_id' => Auth::user()->id,
            'id' => $request->jobId
        ])->first();


        if ($job == null) {
            session()->flash('error','Either job deleted or not found.');
            return response()->json([
                'status' => true
            ]);
        }

        Job::where('id',$request->jobId)->delete();
        session()->flash('success','Job deleted successfully.');
        return response()->json([
            'status' => true
        ]);
    }

    public function myJobApplications(){
        $jobApplications = JobApplication::where('user_id',Auth::user()->id)
            ->orderBy('created_at','DESC')
            ->paginate(10);

        return view('front.account.job.my-job-applications',[
            'jobApplications' => $jobApplications
        ]);
    }

    public function removeJobs(Request $request){
        $jobApplication = JobApplication::where(['id'=> $request->id, 'user_id'=> Auth::user()->id])->first();

        if($jobApplication == null){
            session()->flash('error','Job application not found');
            return response()->json([
                'status' => false,                
            ]);
        }
        
        JobApplication::find($request->id)->delete();
        session()->flash('success','Job application removed successfully.');

        return response()->json([
            'status' => true,                
        ]);
    }

    public function savedJobs(){
        $savedJobs = SavedJob::where('user_id',Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(10);

        return view('front.account.job.saved-jobs', [
            'savedJobs' => $savedJobs
        ]);

    }
    
    public function removeSavedJob(Request $request){
        $savedJob = SavedJob::where(['id'=> $request->id, 'user_id'=> Auth::user()->id])->first();

        if($savedJob == null){
            session()->flash('error','Job not found');
            return response()->json([
                'status' => false,                
            ]);
        }
        
        $savedJob->delete();
        session()->flash('success','Job has been removed from saved.');

        return response()->json([
            'status' => true,                
        ]);
    }

    public function changePassword(Request $request){
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|min:5',
            'confirm_password' => 'required|same:new_password',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        
        if (Hash::check($request->old_password, Auth::user()->password) == false){
            session()->flash('error','Your old password is incorrect.');
            return response()->json([
                'status' => true                
            ]);
        }


        $user = User::find(Auth::user()->id);
        $user->password = Hash::make($request->new_password);  
        $user->save();

        session()->flash('success','Password updated successfully.');
        return response()->json([
            'status' => true                
        ]);
    }
}
