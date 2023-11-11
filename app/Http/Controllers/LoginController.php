<?php

namespace App\Http\Controllers;

use App\Enums\Roles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function create(){
        return inertia(
            'Auth/Login'
        );
    }
    public function store(Request $request){

        if (!Auth::attempt($request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string']
        ]), true))
        {
            throw ValidationException::withMessages(
                [
                    'email' => 'Invalid data'
                ]
            );
        }
        $request->session()->regenerate();
        if(Auth::user()->role==Roles::Candidate){
            return redirect()->route('user.index');
        }
        else if(Auth::user()->role==Roles::Employer){
            return redirect()->route('company.profile');

        }
        return redirect()->intended('/');
    }

    public function destroy(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('jobs.index');
    }
}
