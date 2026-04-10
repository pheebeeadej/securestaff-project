<?php

namespace App\Services;

use App\Models\PasswordHistory;
use App\Models\PasswordPolicy;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PasswordPolicyService
{
    public function assertPasswordMeetsPolicy(string $plainPassword): void
    {
        $this->validatePlainPassword($plainPassword, $this->activePolicy());
    }

    public function activePolicy(): PasswordPolicy
    {
        $policy = PasswordPolicy::query()
            ->where('enabled', true)
            ->latest('id')
            ->first()
            ?? PasswordPolicy::query()->latest('id')->first();

        if ($policy) {
            return $policy;
        }

        return new PasswordPolicy([
            'min_length' => 12,
            'require_uppercase' => true,
            'require_lowercase' => true,
            'require_numeric' => true,
            'require_symbol' => true,
            'history_depth' => 5,
            'expiry_days' => 90,
            'lockout_threshold' => 5,
            'enabled' => true,
        ]);
    }

    public function passwordExpired(User $user): bool
    {
        $policy = $this->activePolicy();

        if ((int) $policy->expiry_days <= 0) {
            return false;
        }

        if ($user->password_changed_at === null) {
            return true;
        }

        return $user->password_changed_at->copy()->addDays((int) $policy->expiry_days)->isPast();
    }

    public function rotatePassword(User $user, string $plainPassword): void
    {
        $policy = $this->activePolicy();
        $this->validatePlainPassword($plainPassword, $policy);
        $this->rejectIfReusedPassword($user, $plainPassword, $policy);

        DB::transaction(function () use ($user, $plainPassword, $policy) {
            PasswordHistory::query()->create([
                'user_id' => $user->id,
                'password_hash' => $user->password,
                'created_at' => now(),
            ]);

            $user->forceFill([
                'password' => Hash::make($plainPassword),
                'must_change_password' => false,
                'password_changed_at' => now(),
            ])->save();

            $this->prunePasswordHistory($user->id, (int) $policy->history_depth);
        });
    }

    private function validatePlainPassword(string $plainPassword, PasswordPolicy $policy): void
    {
        $rules = ['required', 'string', 'min:'.(int) $policy->min_length];

        if ($policy->require_uppercase) {
            $rules[] = 'regex:/[A-Z]/';
        }
        if ($policy->require_lowercase) {
            $rules[] = 'regex:/[a-z]/';
        }
        if ($policy->require_numeric) {
            $rules[] = 'regex:/[0-9]/';
        }
        if ($policy->require_symbol) {
            $rules[] = 'regex:/[\W_]/';
        }

        $validator = Validator::make(
            ['password' => $plainPassword],
            ['password' => $rules],
            ['password.regex' => 'The password does not meet the complexity requirements.']
        );

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    private function rejectIfReusedPassword(User $user, string $plainPassword, PasswordPolicy $policy): void
    {
        if (Hash::check($plainPassword, $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['You cannot reuse your current password.'],
            ]);
        }

        $depth = max(1, (int) $policy->history_depth);
        $hashes = PasswordHistory::query()
            ->where('user_id', $user->id)
            ->orderByDesc('id')
            ->limit($depth)
            ->pluck('password_hash');

        foreach ($hashes as $oldHash) {
            if (Hash::check($plainPassword, $oldHash)) {
                throw ValidationException::withMessages([
                    'password' => ['You cannot reuse a recent password from your history.'],
                ]);
            }
        }
    }

    private function prunePasswordHistory(int $userId, int $historyDepth): void
    {
        $ids = PasswordHistory::query()
            ->where('user_id', $userId)
            ->orderByDesc('id')
            ->skip(max(0, $historyDepth))
            ->pluck('id');

        if ($ids->isNotEmpty()) {
            PasswordHistory::query()->whereIn('id', $ids)->delete();
        }
    }
}
