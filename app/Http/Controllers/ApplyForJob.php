<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\JobAd;
use App\Models\User;
use App\Notifications\UserAppliedForJob;
use Illuminate\Http\Request;

class ApplyForJob extends Controller
{
    public function __invoke(JobAd $job, Request $request){

        if($request->user()===null){
            return redirect()->route('login.create')->with('error', 'You need to be logged in to apply!');
        }
        else if(!$request->user()->userDescription){
            return redirect()->route('user.edit')->with('error', 'You need to fill your profile in order to apply!');

        }
        $application = Application::where('user_id', '=', $request->user()->id)->where('job_ad_id','=', $job->id)->first();
        if($application){
            return redirect()->back()->with('error', 'You have already applied for this job');
        }
        $application = Application::create([
            'user_id' => $request->user()->id,
            'job_ad_id' => $job->id
        ]);

        $job->employer->recruiter->first()->user->notify(new UserAppliedForJob($application));
        return redirect()->back()->with('success', 'You have succesfully applied!');
    }
}
