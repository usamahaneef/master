{{-- @component('mail::header', ['url' => '...'])
    <img src="{{asset('admin/img/admin-banner-image.png')}}" alt="Logo"> 
@endcomponent

@component('mail::message')

    {{ $details['title'] }} 
    <br>
    Hello {{ $details['name'] }} You are receiving this email because we received a password reset request for your account.
    @component('mail::button', ['url' => url($details['password_reset_url'] . '?email=' . urlencode($details['email']))])
    Reset Password
    @endcomponent
    If you did not request a password reset, no further action is required.
    <br>
    Thanks, For Choosing This Platform.

@endcomponent --}}

@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => '...'])
            <img src="{{asset('admin/img/admin-banner-image.png')}}" width="100" alt="Logo"> 
        @endcomponent
    @endslot

    {{-- Body --}}
    @slot('subcopy')
        <h2 style="text-align: center;">{{ $details['title'] }}</h2>
        <p>Hello {{ $details['name'] }},</p>
        
        <p>You are receiving this email because we received a password reset request for your account.</p>
        
        @component('mail::button', ['url' => url($details['password_reset_url'] . '?email=' . urlencode($details['email']))])
            Reset Password
        @endcomponent

        <p>If you did not request a password reset, no further action is required.</p>
    @endslot
@endcomponent

