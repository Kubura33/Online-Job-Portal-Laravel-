<?php

namespace App\Actions;

use App\Models\Application;
use App\Notifications\JobNotification;
use Lorisleiva\Actions\Concerns\AsAction;

class ResponseJobApplication
{
    use AsAction;

    public function handle(Application $application, $type)
    {

        $application->setStatus($type);
        $application->user->notify(new JobNotification(
            $application, $type));
        $message = "";
        switch ($type) {
            case 0:
                $message = "Application has been accepted";
                break;
            case 1:
                $message = "Application has been successfully denied";
                break;
            default:
                break;
        }
        return redirect()->back()->with('success', $message);


    }
}
