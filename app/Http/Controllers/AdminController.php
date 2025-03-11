<?php
namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // For admin check
use Illuminate\Routing\Controller;

class AdminController extends Controller
{
    // Dashboard method
    public function dashboard()
    {
        // Check if the user is authenticated and is an admin
        if (!Auth::check() || Auth::user()->is_admin != 1) {
            return redirect()->route('home')->with('error', 'You do not have admin access.');
        }

        $userCount = User::count();
        $jobCount = JobApplication::count();
        $users = User::all();
        $jobApplications = JobApplication::all();

        return view('admin.dashboard', compact('userCount', 'jobCount', 'users', 'jobApplications'));
    }

    // Delete a user by id
    public function deleteUser($id)
    {
        // Check if the user is authenticated and is an admin
        if (!Auth::check() || Auth::user()->is_admin != 1) {
            return redirect()->route('home')->with('error', 'You do not have admin access.');
        }

        $user = User::find($id);
        if ($user) {
            $user->delete();
            return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully.');
        }
        return redirect()->route('admin.dashboard')->with('error', 'User not found.');
    }

    // Edit a user
    public function editUser($id)
    {
        // Check if the user is authenticated and is an admin
        if (!Auth::check() || Auth::user()->is_admin != 1) {
            return redirect()->route('home')->with('error', 'You do not have admin access.');
        }

        $user = User::find($id);
        if ($user) {
            return view('admin.users.edit', compact('user'));
        }
        return redirect()->route('admin.dashboard')->with('error', 'User not found.');
    }

    // Update a user
    public function updateUser(Request $request, $id)
    {
        // Check if the user is authenticated and is an admin
        if (!Auth::check() || Auth::user()->is_admin != 1) {
            return redirect()->route('home')->with('error', 'You do not have admin access.');
        }

        $user = User::find($id);
        if ($user) {
            $user->update($request->all());
            return redirect()->route('admin.dashboard')->with('success', 'User updated successfully.');
        }
        return redirect()->route('admin.dashboard')->with('error', 'User not found.');
    }

    // Delete a job post by id
    public function deleteJob($id)
    {
        // Check if the user is authenticated and is an admin
        if (!Auth::check() || Auth::user()->is_admin != 1) {
            return redirect()->route('home')->with('error', 'You do not have admin access.');
        }

        $job = JobApplication::find($id);
        if ($job) {
            $job->delete();
            return redirect()->route('admin.dashboard')->with('success', 'Job post deleted successfully.');
        }
        return redirect()->route('admin.dashboard')->with('error', 'Job post not found.');
    }

    // Edit a job post
    public function editJob($id)
    {
        // Check if the user is authenticated and is an admin
        if (!Auth::check() || Auth::user()->is_admin != 1) {
            return redirect()->route('home')->with('error', 'You do not have admin access.');
        }

        $job = JobApplication::find($id);
        if ($job) {
            return view('admin.jobs.edit', compact('job'));
        }
        return redirect()->route('admin.dashboard')->with('error', 'Job post not found.');
    }

    // Update a job post
    public function updateJob(Request $request, $id)
    {
        // Check if the user is authenticated and is an admin
        if (!Auth::check() || Auth::user()->is_admin != 1) {
            return redirect()->route('home')->with('error', 'You do not have admin access.');
        }

        $job = JobApplication::find($id);
        if ($job) {
            $job->update($request->all());
            return redirect()->route('admin.dashboard')->with('success', 'Job post updated successfully.');
        }
        return redirect()->route('admin.dashboard')->with('error', 'Job post not found.');
    }
}
