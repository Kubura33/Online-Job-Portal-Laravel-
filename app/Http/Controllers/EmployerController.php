<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use App\Models\Recruiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployerController extends Controller
{

    public function index()
    {

        $companies = Employer::all();
        $companies->each(function ($company) {
            $company->imageUrl = $company->imagePath;
        });
        return inertia(
            'Company/CompanyIndex',
            [
                'companies' => $companies
            ]
        );
    }

    public function show(Employer $company)
    {
        $company->imageUrl = $company->imagePath;
        return inertia('Company/CompanyShow',
            [
                'company' => $company
            ]);
    }

    public function store(Request $request)
    {


    }

    public function edit(Request $request, $company)
    {
        $company = Employer::find($company);
        return inertia(
            'Company/RecruiterEditProfile',
            [
                'company' => $company
            ]

        );
    }

    public function update(Request $request)
    {
        $company = $request->user()->recruiter->employer;
        $attr = $request->validate(
            [
                'company_name' => ['required', 'string', 'min:3'],
                'city' => ['required'],
                'address' => ['required'],
                'email' => ['required'],
                'company_desc' => ['required'],
                'phone' => ['required'],
                'image' => $request->hasFile('image') ? ['mimes:png,jpg,jpeg,gif'] : []
            ]
        );
        if ($attr['image']) {
            try {
                Storage::disk('employer')->delete($company->imagePath);
            } catch (\Exception $e) {
                \Log::error('File deletion error: ' . $e->getMessage());
            }
            $company->update([
                'name' => $attr['company_name'],
                'city' => $attr['city'],
                'phone' => $attr['phone'],
                'address' => $attr['address'],
                'email' => $attr['email'],
                'description' => $attr['company_desc'],
                'image' => Storage::disk('employer')->putFile($request->file("image"))
            ]);
        } //I know its code repetition and that this could have gone prolly another way, but for now happy with this
        else {
            $company->update([
                'name' => $attr['company_name'],
                'city' => $attr['city'],
                'phone' => $attr['phone'],
                'address' => $attr['address'],
                'email' => $attr['email'],
                'description' => $attr['company_desc'],
            ]);
        }

        return redirect()->route('company.profile')->with('success', 'You have successfully edited your employer/company profile and now you can add jobs!');

    }
}
