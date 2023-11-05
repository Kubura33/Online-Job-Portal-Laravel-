<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobAd;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ViewUserProfile extends Controller
{
    public function index(Request $request, $user)
    {
        $user = User::find($user);


        $jobs = Auth::user()->recruiter->employer->job;
        $jobIds = $jobs->pluck('id')->all();
        $applications = Application::where('job_ad_id', $jobIds)
            ->where('user_id', $user->id)
            ->with('job')
            ->get();

        if ($user) {
            return inertia(
                'Company/ViewUserProfile',
                [
                    'candidate' => $user,
                    'image' => $user->userDescription->imagePath ?? '',
                    'cv' => $user->userDescription->cvPath ?? '',
                    'coverLetter' => $user->userDescription->coverLetterPath ?? '',
                    'applications' => $applications,

                ]
            );
        } else {
            return redirect()->back();
        }
    }
}
