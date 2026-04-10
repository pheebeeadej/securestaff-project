@extends('layouts.app')

@section('page-title', 'Security Policy')
@section('page-subtitle', 'Configure password and lockout controls')

@section('content')
    <div class="panel" style="max-width:960px;">
        <form method="POST" action="{{ route('security.policies.update') }}">
            @csrf
            @method('PUT')

            <div class="form-group"><label>Minimum length</label><input class="form-control" type="number" name="min_length" value="{{ $policy->min_length ?? 12 }}"></div>
            <div class="form-group"><label>Password history depth</label><input class="form-control" type="number" name="history_depth" value="{{ $policy->history_depth ?? 5 }}"></div>
            <div class="form-group"><label>Expiry days</label><input class="form-control" type="number" name="expiry_days" value="{{ $policy->expiry_days ?? 90 }}"></div>
            <div class="form-group"><label>Lockout threshold</label><input class="form-control" type="number" name="lockout_threshold" value="{{ $policy->lockout_threshold ?? 5 }}"></div>

            <label><input type="checkbox" name="require_uppercase" value="1" {{ ($policy->require_uppercase ?? true) ? 'checked' : '' }}> Require uppercase</label><br>
            <label><input type="checkbox" name="require_lowercase" value="1" {{ ($policy->require_lowercase ?? true) ? 'checked' : '' }}> Require lowercase</label><br>
            <label><input type="checkbox" name="require_numeric" value="1" {{ ($policy->require_numeric ?? true) ? 'checked' : '' }}> Require numeric</label><br>
            <label><input type="checkbox" name="require_symbol" value="1" {{ ($policy->require_symbol ?? true) ? 'checked' : '' }}> Require symbol</label><br><br>

            <button class="btn">Save Policy</button>
        </form>
    </div>
@endsection
