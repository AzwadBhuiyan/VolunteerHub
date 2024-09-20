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

    private function generateUserid($userType)
    {
        return User::generateUserid($userType);
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
            'user_type' => ['required', 'in:volunteer,organization'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
        
        $volunteerRules = [
            'userid' => ['required', 'string', 'max:255', 'unique:users'],
            'name' => ['required', 'string', 'max:50'],
            'phone' => ['required', 'string', 'max:11'],
            'nid' => ['nullable', 'string', 'max:20'],
            'gender' => ['required', 'in:M,F,O'],
            'dob' => ['required', 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
            'blood_group' => ['required', 'string', 'max:5'],
            'present_address' => ['required', 'string', 'max:300'],
            'permanent_address' => ['required', 'string', 'max:300'],
            'district' => ['required', 'string'],
            'trained_in_emergency_response' => ['nullable', 'boolean'],
            'bio' => ['nullable', 'string' , 'max:150']
        ];
        
        $organizationRules = [
            'userid' => ['required', 'string', 'max:255', 'unique:users'],
            'org_name' => ['required', 'string', 'max:255'],
            'primary_address' => ['required', 'string', 'max:300'],
            'secondary_address' => ['nullable', 'string', 'max:300'],
            'website' => ['required', 'string', 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/'],
            'org_mobile' => ['required', 'string', 'max:11'],
            'org_telephone' => ['required', 'string', 'between:7,11'],
            'description' => ['required', 'string', 'max:150'],
        ];
        
        $rules = array_merge($commonRules, $request->user_type === 'volunteer' ? $volunteerRules : $organizationRules);
        
        // Filter out disabled fields
        $data = array_filter($request->all(), function ($value, $key) use ($rules) {
            return isset($rules[$key]);
        }, ARRAY_FILTER_USE_BOTH);
        
        $request->validate($rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $userid = $this->generateUserid($request->user_type);

            $user = User::create([
                'userid' => $userid,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
        
            if ($request->user_type === 'volunteer') {
                Volunteer::create([
                    'userid' => $user->userid,
                    'url' => $user->userid,
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
                    'url' => $user->userid,
                    'org_name' => $request->org_name,
                    'primary_address' => $request->primary_address,
                    'secondary_address' => $request->secondary_address,
                    'website' => $request->website,
                    'org_mobile' => $request->org_mobile,
                    'org_telephone' => $request->org_telephone,
                    'verification_status' => 'unverified',
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
