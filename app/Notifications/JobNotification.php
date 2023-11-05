<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JobNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $text = '';

    public function __construct(protected Application $application, protected $type)
    {
        switch ($type) {
            case 0:
                $this->text = "Your application for " . $this->application->job->title . " that you applied for on "
                    . $this->application->created_at->format('Y-m-d H:i:s')
                    . ' has been accepted. You should receive an email from the employer for further communication.
                    Good luck on your interview, we hope you get the job :)!';
                break;
            case 1:
                $this->text = "Your application for " . $this->application->job->title . " that you applied for on"
                    . $this->application->created_at->format('Y-m-d H:i:s')
                    . ' has been denied. We are sorry you didnt make it through.
                    Good luck on your future applications, we hope you make it :)!';
                break;
            default:
                break;
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line($this->text)
            ->action($this->application->job->title . ' job', url(route('jobs.show', $this->application->job)))
            ->line('Thank you for using our application, all the best :)!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'response' => $this->application,
            'text' => $this->text,
            'job_ad' => $this->application->job,
            'employer' => $this->application->job->employer->name,

        ];
    }
}
