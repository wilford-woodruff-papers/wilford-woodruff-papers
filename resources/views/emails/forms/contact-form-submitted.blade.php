@component('mail::message')
# New Contact Form Submitted

{{ $submission->first_name }} {{ $submission->last_name }}

{{ $submission->email }}

{{ $submission->phone }}

{{ $submission->message }}

@component('mail::button', ['url' => config('app.url').'/nova/resources/submissions/'.$submission->id])
View Submission
@endcomponent

@endcomponent
