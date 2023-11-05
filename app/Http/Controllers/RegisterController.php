<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use App\Models\Recruiter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function create()
    {
        return inertia(
            'Auth/Register'
        );
    }

    public function store(Request $request)
    {

        $user = User::create($request->validate([
            'name' => ['required', 'max:255'],
            'lastname' => ['required', 'max:255'],
            'email' => ['required', 'max:255', 'unique:' . User::class],
            'phone' => ['required', 'max:12', 'unique:' . User::class],
            'password' => ['required', 'min:8', 'confirmed'],
            'role' => ['required']
        ]));
        if($request->role==1){
            $employer = Employer::create();
            Recruiter::create([
                'user_id' => $user->id,
                'employer_id' => $employer->id,
            ]);
        }
        Auth::login($user);
        return redirect()->intended('/');
    }
}
