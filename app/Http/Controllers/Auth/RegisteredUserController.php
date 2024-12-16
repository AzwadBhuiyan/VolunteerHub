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

    private function createTutorialProgress($userid)
    {
        // Page names from tutorial.js
        $tutorialPages = [
            'volunteer_dashboard',
            'volunteer_profile',
            'favorites',
            'home'
        ];

        foreach ($tutorialPages as $pageName) {
            \App\Models\TutorialProgress::create([
                'userid' => $userid,
                'page_name' => $pageName,
                'dont_show_again' => false,
                'last_step_seen' => 0
            ]);
        }
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        \Log::info('Registration attempt', [
            'user_type' => $request->user_type,
            'all_data' => $request->all()
        ]);

        $commonRules = [
            'user_type' => ['required', 'in:volunteer,organization'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
        
        $volunteerRules = [
            'userid' => ['required', 'string', 'max:255', 'unique:users'],
            'name' => ['required', 'string', 'max:50'],
            'phone' => ['required', 'string', 'size:11'],
            'gender' => ['required', 'in:M,F,O'],
            'dob' => ['required', 'date', 'before_or_equal:' . now()->subYears(18)->format('Y-m-d')],
            'present_address' => ['required', 'string', 'max:300'],
            'district' => ['required', 'string'],
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

        try {
            $userid = $this->generateUserid($request->user_type);

            $user = User::create([
                'userid' => $userid,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->user_type,
            ]);
        
            if ($request->user_type === 'volunteer') {
                \Log::info('Creating volunteer', [
                    'userid' => $userid,
                    'data' => $request->only(['name', 'phone', 'gender', 'dob', 'present_address', 'district'])
                ]);
                
                Volunteer::create([
                    'userid' => $user->userid,
                    'url' => $user->userid,
                    'Name' => $request->name,
                    'Phone' => $request->phone,
                    'Gender' => $request->gender,
                    'DOB' => $request->dob,
                    'PresentAddress' => $request->present_address,
                    'District' => $request->district,
                    'BloodGroup' => 'Not Set',  // Default value
                    'PermanentAddress' => $request->present_address,  // Use present address as default
                    'TrainedInEmergencyResponse' => false,
                    'Points' => 0,
                    'Badges' => null,
                    'bio' => null,
                    'allow_follow' => true  // Default to allowing follows
                ]);

                $this->createTutorialProgress($user->userid);

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

            $user->sendEmailVerificationNotification();


            return redirect()->route('login')
                ->with('status', 'Please check your email for a verification link.');
        } catch (\Exception $e) {
            \Log::error('Registration failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
}
