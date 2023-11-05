<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->user()->userDescription){
            return redirect()->route('user.edit');
        }
        return inertia('User/UserProfile',
            [
                'bio' => $request->user()->userDescription,
                'cvUrl' => $request->user()->userDescription ? $request->user()->userDescription->cvPath : '',
                'image' => $request->user()->userDescription ? $request->user()->userDescription->imagePath: '',
                'coverLetter' => $request->user()->userDescription ? $request->user()->userDescription->coverLetterPath: '',
                'applications' => Application::with('job.employer')
                    ->with('user')
                    ->where('user_id', $request->user()->id)
                    ->get(),
                'jobs' => Application::with('user')->with('job')->get()
            ]);
    }

    public function upload(Request $request)
    {
        if($request->hasFile('image')){
        $request->validate(
            ['image' => ['required', 'mimes:png,jpeg']
            ]
        );
        }




        $user = $request->user()->userDescription;
        $user->update(['profile_image' => Storage::disk('profile')->putFile($request->file("image")) ]);
        $user->save();
        return redirect()->back()->with('success', 'Image uploaded successfully!');

    }
}
