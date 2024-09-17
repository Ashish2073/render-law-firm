<?php

namespace App\Listeners;

use App\Events\SendOtpVarificationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\user;
use Illuminate\Support\Carbon;


class SaveSendOtpMail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SendOtpVarificationMail $event): void
    {
        $user = $event->userdata;
        $userotp = $event->userotp;
        $model=$event->model;

        $model::where('id', $user->id)->update([
            'otp' => $userotp,
            'otp_created_at' => Carbon::now(),
        ]);
    }
}
