<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\User\GeneralNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GeneralNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $title ;
    public $message;
    public $userId;
    
    /**
     * Create a new job instance.
     */
    public function __construct(string $title = null, string $message = null , $userId)
    {
        $this->userId = $userId;
        $this->title = $title;
        $this->message = $message;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = User::whereId($this->userId)->with('devices')->first();
        if(!$user)
        {
            Log::info("No User found");
        }

        $user->notify(new GeneralNotification(
            $this->title,
            $this->message,
        ));

        foreach ($user->devices as $device) {
            $this->firebase_notify($this->title, $this->message, $device->device_token, [
                'title' => $this->title,
                'body' => $this->message,
                'notification_type' => 'dispatch',
            ], $device->device_type);
        }
    }

    public function firebase_notify($notif_title, $notif_body, $recipient, $data, $device_type, $debug = false)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $notification = $device_type == 'ios' ? array('title' => $notif_title, 'body' => $notif_body)
            : array('title' => $notif_title, 'body' => $notif_body, 'sound' => 'carhorn.wav', 'badge' => '1');

        $data['priority'] = 'high'; // high priority set to notification
        if ($device_type == 'ios') {
            $fields = array(
                'to' => $recipient,
                'data' => $data,
                'notification' => $notification,
            );
        } else {
            $fields = array(
                'to' => $recipient,
                'data' => $data,
                'notification' => $notification,
                'priority' => 'high'
            ); 
        }
        $json = json_encode($fields);
        $headers = array(
            'Authorization: key=AAAAnRovHZY:APA91bGWOj1EWsuLERKs52tTsPEFkHrMY8-fpTZUWvP5hpbYKFuU4jG7r7U6KspiVqPbayDG76oyPfpvXauRF7BPHEKAU0wgdiuXx3c-H1k-hM08x-7fZSUKxeva-4L8t1yy-EEpL2AB',
            'Content-Type: application/json'
        );
        /* $ch = curl_init();
         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_POST, true);
         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         curl_setopt($ch, CURLOPT_POSTFIELDS, $json);*/
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);

        if ($debug) {
            echo $result;
        }

        curl_close($ch);
    }
}
