<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notifications\PushNotification;
use App\Events\SendPushNotification;
use App\Models\User;

class NotificationController extends Controller
{
    public function send(Request $request)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $title = $request->input('title');
        $description = $request->input('description');

        event(new SendPushNotification($title, $description));

       

        $users = User::all();

        foreach ($users as $user) {

          
            ($user->notify(new PushNotification($title, $description)));
        }

        return redirect()->back()->with('success', 'Notification sent successfully!');
    }
}
