<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecruiterController extends Controller
{
    public function index(Request $request){
        if(!$request->user()->recruiter->employer->name){

            return redirect()->route('company.edit', $request->user()->recruiter->employer);
        }

        return inertia(
            'Company/RecruiterProfile',
            [
                'jobs' =>$request->user()->recruiter ? $request->user()->recruiter->employer->job : null

            ]
        );
    }
}
