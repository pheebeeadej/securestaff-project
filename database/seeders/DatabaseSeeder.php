<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\LeaveRequest;
use App\Models\Notice;
use App\Models\PasswordHistory;
use App\Models\PasswordPolicy;
use App\Models\PayrollSummary;
use App\Models\SecurityEvent;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::transaction(function (): void {
            PasswordHistory::query()->delete();
            Attendance::query()->delete();
            LeaveRequest::query()->delete();
            PayrollSummary::query()->delete();
            Notice::query()->delete();
            SecurityEvent::query()->delete();
            User::query()->delete();
            PasswordPolicy::query()->delete();

            PasswordPolicy::query()->create([
                'min_length' => 12,
                'require_uppercase' => true,
                'require_lowercase' => true,
                'require_numeric' => true,
                'require_symbol' => false,
                'history_depth' => 5,
                'expiry_days' => 90,
                'lockout_threshold' => 5,
                'enabled' => true,
            ]);

            $sharedPassword = 'Password12345678';
            $sharedPasswordHash = Hash::make($sharedPassword);
            $now = Carbon::now();

            $admin = User::query()->create([
                'name' => 'HR Admin',
                'email' => 'hr.admin@securestaff.test',
                'department' => 'Human Resources',
                'role' => 'admin',
                'password' => $sharedPasswordHash,
                'must_change_password' => false,
                'password_changed_at' => $now,
                'failed_login_attempts' => 0,
                'locked_until' => null,
                'two_factor_enabled' => true,
            ]);

            $staff = User::query()->create([
                'name' => 'Staff User',
                'email' => 'staff@securestaff.test',
                'department' => 'Operations',
                'role' => 'employee',
                'password' => $sharedPasswordHash,
                'must_change_password' => false,
                'password_changed_at' => $now,
                'failed_login_attempts' => 0,
                'locked_until' => null,
                'two_factor_enabled' => true,
            ]);

            PasswordHistory::query()->insert([
                [
                    'user_id' => $admin->id,
                    'password_hash' => $sharedPasswordHash,
                    'created_at' => $now,
                ],
                [
                    'user_id' => $staff->id,
                    'password_hash' => $sharedPasswordHash,
                    'created_at' => $now,
                ],
            ]);

            SecurityEvent::query()->create([
                'user_id' => $admin->id,
                'event_type' => 'seeded_login',
                'severity' => 'low',
                'description' => 'Initial admin account seeded for local development.',
                'ip_address' => '127.0.0.1',
                'meta' => ['source' => 'database-seeder'],
            ]);

            SecurityEvent::query()->create([
                'user_id' => $staff->id,
                'event_type' => 'seeded_account_created',
                'severity' => 'low',
                'description' => 'Staff account seeded with shared starter password.',
                'ip_address' => '127.0.0.1',
                'meta' => ['source' => 'database-seeder'],
            ]);

            Notice::query()->create([
                'title' => 'Welcome to SecureStaff',
                'body' => 'This is a seeded notice for onboarding and dashboard preview.',
                'published_at' => $now,
                'published_by' => $admin->id,
            ]);

            Attendance::query()->create([
                'user_id' => $staff->id,
                'work_date' => $now->copy()->subDay()->toDateString(),
                'clock_in_at' => $now->copy()->subDay()->setTime(8, 2),
                'clock_out_at' => $now->copy()->subDay()->setTime(17, 4),
                'status' => 'present',
            ]);

            LeaveRequest::query()->create([
                'user_id' => $staff->id,
                'start_date' => $now->copy()->addDays(7)->toDateString(),
                'end_date' => $now->copy()->addDays(9)->toDateString(),
                'reason' => 'Seeded annual leave request.',
                'status' => 'pending',
            ]);

            PayrollSummary::query()->create([
                'user_id' => $staff->id,
                'month' => $now->copy()->startOfMonth()->toDateString(),
                'gross_pay' => 250000.00,
                'deductions' => 25000.00,
                'net_pay' => 225000.00,
            ]);
        });
    }
}
