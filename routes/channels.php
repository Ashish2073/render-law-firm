<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});


Broadcast::channel('case-message-channel', function ($user, $cases_id) {
    
    if (auth('customer')->check()) {
        return auth('customer')->user()->isPartOfCase($cases_id);
    } elseif (auth('lawyer')->check()) {
        return auth('lawyer')->user()->isPartOfCase($cases_id);
    } elseif (auth('web')->check() && in_array("admin",json_decode(auth()->user()->getRoleNames()))) {
        return true;
    }

    return false; 
});
 