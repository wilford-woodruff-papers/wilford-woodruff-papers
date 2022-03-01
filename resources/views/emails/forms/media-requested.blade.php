@component('mail::message')
# Media Request Form Submitted

{{ $submission->email }}

{{ $submission->phone }}

{{ $submission->message }}

@component('mail::button', ['url' => config('app.url').'/nova/resources/submissions/'.$submission->id])
View Request
@endcomponent

@endcomponent
