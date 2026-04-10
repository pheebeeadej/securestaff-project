@extends('layouts.app')

@section('page-title', 'Profile')
@section('page-subtitle', 'Personal information and account status')

@section('content')
    <div class="panel">
        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Department:</strong> {{ $user->department }}</p>
        <p><strong>Role:</strong> {{ $user->role }}</p>
        <p><strong>Password Last Changed:</strong> {{ $user->password_changed_at ?? 'Pending first change' }}</p>
        <a class="btn" href="{{ route('security.change-password') }}">Change Password</a>
    </div>
@endsection
