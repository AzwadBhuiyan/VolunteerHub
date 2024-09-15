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
            'name' => ['string', 'max:255'],
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id, 'id')],
        ];

        if ($this->user()->volunteer) {
            $rules = array_merge($rules, [
                'profile_picture' => ['nullable', 'image'],
                'bio' => ['nullable', 'string', 'max:1000'],
                'phone' => ['required', 'string', 'max:20'],
                'blood_group' => ['required', 'string', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
            ]);
        } elseif ($this->user()->organization) {
            $rules = array_merge($rules, [
                'logo' => ['nullable', 'image', 'max:1024'],
                'cover_image' => ['nullable', 'image', 'max:2048'],
                'description' => ['required', 'string', 'max:1000'],
                'website' => ['required', 'url', 'max:255'],
                'phone' => ['required', 'string', 'max:20'],
                'address' => ['required', 'string', 'max:255'],
            ]);
        }

        return $rules;
    }
}