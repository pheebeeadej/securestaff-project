@extends('layouts.app')

@section('page-title', 'Profile')
@section('page-subtitle', 'Personal information and account status')

@section('content')
    @if($errors->any())
        <div class="panel" style="margin-bottom:16px; border-left:4px solid #f97373;">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="split">
        <div class="panel">
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Department:</strong> {{ $user->department }}</p>
            <p><strong>Role:</strong> {{ $user->role }}</p>
            <p><strong>Password Last Changed:</strong> {{ $user->password_changed_at ?? 'Pending first change' }}</p>
            <a class="btn" href="{{ route('security.change-password') }}">Change Password</a>
        </div>

        <div class="panel">
            <h3>Email Two-Factor Authentication</h3>
            <p class="muted">Status: {{ $user->two_factor_enabled ? 'Enabled (default)' : 'Disabled' }}</p>
            <form method="POST" action="{{ route('profile.security.2fa') }}">
                @csrf
                <input type="hidden" name="enabled" value="{{ $user->two_factor_enabled ? '0' : '1' }}">
                <button class="btn" type="submit">{{ $user->two_factor_enabled ? 'Disable 2FA' : 'Enable 2FA' }}</button>
            </form>
        </div>
    </div>
@endsection
