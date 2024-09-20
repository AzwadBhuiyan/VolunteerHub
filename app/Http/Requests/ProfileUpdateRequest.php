<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'name' => ['string', 'max:50'],
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($this->user()->userid, 'userid')],
            'new_userid' => ['sometimes', 'string', 'max:255', Rule::unique(User::class, 'userid')->ignore($this->user()->userid, 'userid')],
        ];

        if ($this->user()->volunteer) {
            $rules = array_merge($rules, [
                'profile_picture' => ['nullable', 'image', 'max:5120'],
                'bio' => ['nullable', 'string', 'max:150'],
                'phone' => ['required', 'string', 'max:11'],
                'blood_group' => ['required', 'string', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
            ]);
        } elseif ($this->user()->organization) {
            $rules = array_merge($rules, [
                'logo' => ['nullable', 'image', 'max:5120'],
                'cover_image' => ['nullable', 'image', 'max:5120'],
                'description' => ['required', 'string', 'max:150'],
                'website' => ['nullable', 'string', 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/'],
                'primary_address' => ['required', 'string', 'max:300'],
                'secondary_address' => ['nullable', 'string', 'max:300'],
                'org_mobile' => ['required', 'string', 'max:11'],
                'org_telephone' => ['nullable', 'string', 'between:7,11'],
            ]);
        }

        return $rules;
    }
}