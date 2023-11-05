<?php

namespace App\Http\Controllers;

use App\Models\UserDescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class UserDescriptionController extends Controller
{
    public function store(Request $request)
    {
        $array = $request->validate(
            [
                'experience' => ['required', 'string'],
                'education' => ['required', 'string'],
                'cover_letter' => ['mimes:pdf,dox,docx,jpg,png'],
                'cv' => ['required', 'mimes:pdf,doc,docx,jpg,png'],
                'about' => ['required', 'string'],
                'profile_image' => ['mimes:jpg,png,gif']
            ]
        );
        if($request->user()->userDescription){
            $this->update($array, $request);
        }
        else{
        UserDescription::create([
            'user_id' => $request->user()->id,
            'experience' => $request->experience,
            'education' => $request->education,
            'CV' => Storage::disk('profile')->putFile($request->file("cv")),
            'about_me' => $request->about,
            'profile_image' => Storage::disk('profile')->putFile($request->file("profile_image")),
            'cover_letter' => Storage::disk('profile')->putFile($request->file("coverLetter"))
        ]);
        }
        return redirect()->route('user.index')->with('success', 'You have successfully edited your profile!');
    }

    public function edit( Request $request)
    {
        return inertia(
            'User/UserProfileUpdate',
            [
                'description' => $request->user()->userDescription ?? null ,
                'cv' => $request->user()->userDescription ? $request->user()->userDescription->cvPath : '',
                'coverLetter' => $request->user()->userDescription ? $request->user()->userDescription->coverLetterPath : '',
                'image' => $request->user()->userDescription ? $request->user()->userDescription->imagePath : '',
            ]
        );

    }
    public function update($array, Request $request){
        $user = $request->user()->userDescription;
        try{
        Storage::disk('profile')->delete($user->cvPath);
        Storage::disk('profile')->delete($user->imagePath);
        Storage::disk('profile')->delete($user->coverLetterPath);
        } catch (\Exception $e){
            \Log::error('File deletion error: ' . $e->getMessage());
        }
        $user->update([
            'experience' => $array['experience'],
            'education' => $array['education'],
            'about_me' => $array['about'],
            'profile_image' => Storage::disk('profile')->putFile($request->file("profile_image")),
            'cover_letter' => Storage::disk('profile')->putFile($request->file("coverLetter")),
            'CV' => Storage::disk('profile')->putFile($request->file("cv")),

        ]);
    }
}
