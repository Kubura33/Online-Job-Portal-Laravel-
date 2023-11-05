<?php

namespace App\Http\Controllers;

use App\Actions\ResponseJobApplication;
use App\Jobs\MailJob;
use App\Models\Application;
use App\Models\User;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index($userId, Application $application)
    {
        if ($application->denied != -1) {
            return redirect()->route('company.profile')->with('error', "User's application is closed, you cant access it!");

        }
        $candidate = User::find($userId);
        $jobTitle = $application->job->title;

        return inertia(
            'Company/InvitationEmail',
            [
                'application' => $application,
                'candidate' => $candidate,
                'jobTitle' => $jobTitle
            ]
        );
    }

    //This method acts as a Mail dispatcher, also changes the application status
    public function store(Request $request)
    {

        $attr = $request->validate([
            'from' => ['email', 'required'],
            'to' => ['email', 'required'],
            'jobTitle' => ['required'],
            'text' => ['required', 'string'],
            'application' => ['required']
        ]);
        $app = Application::find($attr['application'])->first();

        MailJob::dispatch($attr['from'], $attr['to'], $attr['text']);
        ResponseJobApplication::run($app, 1);
        return redirect()->route('company.profile')->with('success', 'User has been successfully invited to interview');

    }
}
