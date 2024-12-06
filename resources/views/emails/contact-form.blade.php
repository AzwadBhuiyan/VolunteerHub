@component('mail::message')
# New Contact Form Submission

**From:** {{ $data['email'] }}  
**Subject:** {{ $data['subject'] }}

**Message:**  
{{ $data['description'] }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent