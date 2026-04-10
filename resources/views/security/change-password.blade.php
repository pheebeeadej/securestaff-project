@extends('layouts.app')

@section('page-title', 'Change Password')
@section('page-subtitle', 'Your password must satisfy the active organizational policy')

@section('content')
    <div class="panel" style="max-width:900px;">
        @if($errors->any())
            <div class="panel" style="margin-bottom:16px; border-left:4px solid #f97373;">
                <strong>Password update failed.</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('security.update-password') }}">
            @csrf
            <div class="form-group">
                <label>New password</label>
                <input id="password" class="form-control" type="password" name="password" data-password-toggle="true" data-min-length="{{ $policy->min_length }}" required>
            </div>
            <div class="form-group">
                <label>Confirm new password</label>
                <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" data-password-toggle="true" required>
            </div>

            <div class="panel" style="margin-bottom:16px;">
                <strong>Active password policy</strong>
                <ul style="list-style:none; padding-left:0; margin:12px 0 0;">
                    <li style="margin-bottom:8px;">
                        <label><input id="rule-length" type="checkbox" disabled> Minimum length ({{ $policy->min_length }} characters)</label>
                    </li>
                    @if($policy->require_uppercase)
                        <li style="margin-bottom:8px;">
                            <label><input id="rule-uppercase" type="checkbox" disabled> At least one uppercase letter</label>
                        </li>
                    @endif
                    @if($policy->require_lowercase)
                        <li style="margin-bottom:8px;">
                            <label><input id="rule-lowercase" type="checkbox" disabled> At least one lowercase letter</label>
                        </li>
                    @endif
                    @if($policy->require_numeric)
                        <li style="margin-bottom:8px;">
                            <label><input id="rule-numeric" type="checkbox" disabled> At least one number</label>
                        </li>
                    @endif
                    @if($policy->require_symbol)
                        <li style="margin-bottom:8px;">
                            <label><input id="rule-symbol" type="checkbox" disabled> At least one symbol</label>
                        </li>
                    @endif
                    <li>
                        <label><input id="rule-confirmed" type="checkbox" disabled> Password and confirmation match</label>
                    </li>
                </ul>
            </div>

            <button class="btn">Update Password</button>
        </form>
    </div>

    <script>
        (() => {
            const passwordInput = document.getElementById('password');
            const confirmInput = document.getElementById('password_confirmation');

            if (!passwordInput || !confirmInput) return;

            const minLength = Number.parseInt(passwordInput.dataset.minLength || '0', 10);
            const checks = {
                length: document.getElementById('rule-length'),
                uppercase: document.getElementById('rule-uppercase'),
                lowercase: document.getElementById('rule-lowercase'),
                numeric: document.getElementById('rule-numeric'),
                symbol: document.getElementById('rule-symbol'),
                confirmed: document.getElementById('rule-confirmed'),
            };

            const updateChecklist = () => {
                const password = passwordInput.value || '';
                const confirmation = confirmInput.value || '';

                if (checks.length) checks.length.checked = password.length >= minLength;
                if (checks.uppercase) checks.uppercase.checked = /[A-Z]/.test(password);
                if (checks.lowercase) checks.lowercase.checked = /[a-z]/.test(password);
                if (checks.numeric) checks.numeric.checked = /[0-9]/.test(password);
                if (checks.symbol) checks.symbol.checked = /[\W_]/.test(password);
                if (checks.confirmed) checks.confirmed.checked = password.length > 0 && password === confirmation;
            };

            passwordInput.addEventListener('input', updateChecklist);
            confirmInput.addEventListener('input', updateChecklist);
            updateChecklist();
        })();
    </script>
@endsection
