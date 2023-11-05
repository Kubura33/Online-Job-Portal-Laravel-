<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request){
        return inertia(
            'Notifications/Index'
            ,
            [
                'notifications' => $request->user()->notifications()->orderBy('created_at', 'desc')->get()
            ]
        );
    }
    public function update(Request $request, $id){
        $notification= $request->user()->notifications->where('id', $id);
        $notification->markAsRead();
    }
}
