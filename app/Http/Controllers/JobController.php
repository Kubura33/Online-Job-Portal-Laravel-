<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use App\Models\Application;
use App\Models\JobAd;
use Illuminate\Http\Request;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jobs = JobAd::with('employer')->paginate(10);
        $jobs->each(function ($job) {
            $job->imagePath = $job->employer->imagePath;
        });

        return inertia('Index/Index',
        [
            'jobs' => $jobs,

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return inertia(
            'Company/CreateJob'
        );

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attr = $request->validate([
            'title' => ['required', 'string'],
            'requirements' => ['required', 'string'],
            'description' => ['required', 'string'],
            'location' => ['required', 'string'],
            'end_of_job_ad' => ['required']
        ]);

        JobAd::create([...$attr,'employer_id' => $request->user()->recruiter->employer->id] );
        return redirect()->route('company.profile')->with('success', 'Job has been successfully added');
    }

    /**
     * Display the specified resource.
     */
    public function show( JobAd $job)
    {

        return inertia('Jobs/JobView',
            [
                'job' => $job->with('employer:id,name')->first(),
                'applications' => Application::with('user')->where('job_ad_id', $job->id)->get()
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JobAd $job)
    {
        return inertia('Jobs/JobEdit',
            [
                'job' => $job
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JobAd $job)
    {

        $job->update($request->validate([
            'title' => ['required', 'string'],
            'requirements' => ['required', 'string'],
            'description' => ['required', 'string'],
            'location' => ['required', 'string'],
            'end_of_job_ad' => ['required']
        ]));
        return redirect()->back()->with('success', 'Job post has been edited successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JobAd $job)
    {
//        $job = JobAd::find($id);
        $job->deleteOrFail();
        return redirect()->back()->with('success', 'Job has been successfully deleted!');
    }
}
