<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    private const FIRST_STAGE_MAX_ATTEMPTS = 5;
    private const SECOND_STAGE_MAX_ATTEMPTS = 10;
    private const FIRST_STAGE_LOCKOUT_SECONDS = 60;
    private const SECOND_STAGE_LOCKOUT_SECONDS = 3600;

    private ?array $lockoutPayload = null;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    public function authenticate(): void
    {
        $state = $this->ensureIsNotLocked();

        // Cek apakah username ada di database
        $user = User::where('username', $this->username)->first();

        if (!$user) {
            $this->recordFailedAttempt($state, 'username', 'Nama pengguna tidak ditemukan');
        }

        // Jika username ada, lakukan attempt terhadap password
        if (!Auth::attempt([
            'username' => $this->username,
            'password' => $this->password,
        ], $this->boolean('remember'))) {
            $this->recordFailedAttempt($state, 'password', 'Kata sandi yang Anda masukkan salah.');
        }

        $this->clearThrottleState();
    }

    public function lockoutPayload(): ?array
    {
        return $this->lockoutPayload;
    }

    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('username')) . '|' . $this->ip());
    }

    private function ensureIsNotLocked(): array
    {
        $state = $this->getThrottleState();
        $lockoutUntil = $state['lockout_until'];

        if (!$lockoutUntil) {
            return $state;
        }

        $remainingSeconds = max(0, $lockoutUntil - now()->timestamp);

        if ($remainingSeconds === 0) {
            return $this->advanceThrottleStateAfterLockout($state);
        }

        $this->throwLockoutException($state, $remainingSeconds);
    }

    private function recordFailedAttempt(array $state, string $field, string $message): void
    {
        $state['attempts']++;

        if ($state['phase'] === 1 && $state['attempts'] >= self::FIRST_STAGE_MAX_ATTEMPTS) {
            $state['lockout_until'] = now()->addSeconds(self::FIRST_STAGE_LOCKOUT_SECONDS)->timestamp;
            $state['next_phase'] = 2;

            $this->storeThrottleState($state);
            $this->throwLockoutException($state, self::FIRST_STAGE_LOCKOUT_SECONDS);
        }

        if ($state['phase'] === 2 && $state['attempts'] >= self::SECOND_STAGE_MAX_ATTEMPTS) {
            $state['lockout_until'] = now()->addSeconds(self::SECOND_STAGE_LOCKOUT_SECONDS)->timestamp;
            $state['next_phase'] = 1;

            $this->storeThrottleState($state);
            $this->throwLockoutException($state, self::SECOND_STAGE_LOCKOUT_SECONDS);
        }

        $this->storeThrottleState($state);

        throw ValidationException::withMessages([
            $field => $message,
        ]);
    }

    private function advanceThrottleStateAfterLockout(array $state): array
    {
        if ($state['phase'] === 1 && $state['next_phase'] === 2) {
            $nextState = [
                'phase' => 2,
                'attempts' => 0,
                'lockout_until' => null,
                'next_phase' => null,
            ];

            $this->storeThrottleState($nextState);

            return $nextState;
        }

        $this->clearThrottleState();

        return $this->defaultThrottleState();
    }

    private function throwLockoutException(array $state, int $remainingSeconds): never
    {
        $isFinalBlock = $state['phase'] === 2;
        $message = $this->buildLockoutMessage($isFinalBlock, $remainingSeconds);

        $this->lockoutPayload = [
            'title' => $isFinalBlock ? 'Login Diblokir Sementara' : 'Terlalu Banyak Percobaan',
            'message' => $message,
            'retry_after' => $remainingSeconds,
            'type' => $isFinalBlock ? 'blocked' : 'warning',
        ];

        throw ValidationException::withMessages([
            'throttle' => $message,
        ]);
    }

    private function buildLockoutMessage(bool $isFinalBlock, int $remainingSeconds): string
    {
        $waitTime = $this->formatDuration($remainingSeconds);

        if ($isFinalBlock) {
            return "Anda sudah salah 10 kali setelah masa tunggu. Login diblokir selama {$waitTime}.";
        }

        return "Percobaan login gagal 5 kali. Coba lagi dalam {$waitTime}. Setelah itu Anda memiliki 10 kesempatan lagi.";
    }

    private function formatDuration(int $seconds): string
    {
        if ($seconds >= 3600) {
            $hours = intdiv($seconds, 3600);
            $minutes = intdiv($seconds % 3600, 60);

            if ($minutes === 0) {
                return "{$hours} jam";
            }

            return "{$hours} jam {$minutes} menit";
        }

        if ($seconds >= 60) {
            $minutes = intdiv($seconds, 60);
            $remainingSeconds = $seconds % 60;

            if ($remainingSeconds === 0) {
                return "{$minutes} menit";
            }

            return "{$minutes} menit {$remainingSeconds} detik";
        }

        return "{$seconds} detik";
    }

    private function getThrottleState(): array
    {
        $state = Cache::get($this->cacheKey(), $this->defaultThrottleState());

        return array_merge($this->defaultThrottleState(), is_array($state) ? $state : []);
    }

    private function storeThrottleState(array $state): void
    {
        Cache::put($this->cacheKey(), $state, now()->addDay());
    }

    private function clearThrottleState(): void
    {
        Cache::forget($this->cacheKey());
        $this->lockoutPayload = null;
    }

    private function cacheKey(): string
    {
        return 'login-lockout:' . $this->throttleKey();
    }

    private function defaultThrottleState(): array
    {
        return [
            'phase' => 1,
            'attempts' => 0,
            'lockout_until' => null,
            'next_phase' => null,
        ];
    }
}
