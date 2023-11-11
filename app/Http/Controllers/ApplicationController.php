<?php

namespace App\Http\Controllers;

use App\Actions\ResponseJobApplication;
use App\Enums\ApplicationStatus;
use App\Jobs\MailJob;
use App\Models\Application;
use App\Models\User;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index(User $user, Application $application)
    {
        if ($application->denied != ApplicationStatus::UNANSWERED) {
            return redirect()->route('company.profile')->with('error', "User's application is closed, you cant access it!");

        }

        $jobTitle = $application->job->title;

        return inertia(
            'Company/InvitationEmail',
            [
                'application' => $application,
                'candidate' => $user,
                'jobTitle' => $jobTitle
            ]
        );
    }

    //This method acts as a Mail dispatcher, also changes the application status
    public function store(Request $request)
    {

        $request->validate([
            'from' => ['email', 'required'],
            'to' => ['email', 'required'],
            'jobTitle' => ['required'],
            'text' => ['required', 'string'],
            'application' => ['required']
        ]);
        $app = Application::find($request->application)->first();

        MailJob::dispatch($request->from, $request->to, $request->text);
        ResponseJobApplication::run($app, ApplicationStatus::ACCEPTED);
        return redirect()->route('company.profile')->with('success', 'User has been successfully invited to interview');

    }
}
