<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

use App\Models\Volunteer;
use App\Models\Organization;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(Request $request): View
    {
        $userType = $request->query('type', 'volunteer');
        return $userType === 'organization' ? view('auth.register-org') : view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // \Log::info('Registration attempt', $request->all());

        $commonRules = [
            'userid' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z0-9_-]+$/',
                'not_in:admin,root,superuser',
                'unique:users',
            ],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];

        if ($request->user_type === 'volunteer') {
            $rules = array_merge($commonRules, [
                'phone' => ['required', 'string', 'max:20'],
                'nid' => ['nullable', 'string', 'max:20'],
                'gender' => ['required', 'in:M,F,O'],
                'dob' => ['required', 'date'],
                'blood_group' => ['required', 'string', 'max:5'],
                'present_address' => ['required', 'string'],
                'permanent_address' => ['required', 'string'],
                'district' => ['required', 'string'],
                'trained_in_emergency_response' => ['nullable', 'boolean'],
            ]);
        } else {
            $rules = array_merge($commonRules, [
                'contact' => ['required', 'string', 'max:20'],
                'category' => ['required', 'string'],
                'address' => ['required', 'string'],
            ]);
        }

        $validator = Validator::make($request->all(), $rules, [
            'userid.unique' => 'This UserID is already taken. Please choose a different one.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $user = User::create([
                'userid' => $request->userid,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            if ($request->user_type === 'volunteer') {
                Volunteer::create([
                    'userid' => $user->userid,
                    'Name' => $request->name,
                    'Phone' => $request->phone,
                    'NID' => $request->nid,
                    'Gender' => $request->gender,
                    'DOB' => $request->dob,
                    'BloodGroup' => $request->blood_group,
                    'PresentAddress' => $request->present_address,
                    'PermanentAddress' => $request->permanent_address,
                    'District' => $request->district,
                    'TrainedInEmergencyResponse' => $request->has('trained_in_emergency_response'),
                ]);
            } else {
                Organization::create([
                    'userid' => $user->userid,
                    'name' => $request->name,
                    'contact' => $request->contact,
                    'category' => $request->category,
                    'address' => $request->address,
                    'verification_status' => 'pending',
                ]);
            }

            event(new Registered($user));

            Auth::login($user);

            // Instead of logging in the user, redirect them to a page asking to verify email
            return redirect()->route('verification.notice')->with('status', 'Please check your email for a verification link.');
        } catch (\Exception $e) {
            \Log::error('Registration failed: ' . $e->getMessage());
            return redirect()->back()->withInput()->withErrors(['error' => 'Registration failed. Please try again.']);
        }
    }
}
