<?php

namespace App\Http\Requests\Auth;

use App\Models\Dosen;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
            'login_as' => ['nullable', 'in:dosen,kajur'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $identifier = $this->string('username')->trim()->toString();
        $username = $this->resolveUsername($identifier);

        if (! Auth::attempt([
            'username' => $username,
            'password' => $this->string('password')->toString(),
        ], $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'username' => trans('auth.failed'),
            ]);
        }

        $requestedRole = $this->input('login_as');
        $userRole = Auth::user()->role;

        if ($userRole === 'kajur') {
            $this->session()->put('active_role', $requestedRole ?: 'kajur');
        } elseif ($userRole === 'dosen') {
            if ($requestedRole === 'kajur') {
                Auth::logout();
                RateLimiter::hit($this->throttleKey());

                throw ValidationException::withMessages([
                    'username' => 'Akun dosen tidak memiliki akses sebagai kajur.',
                ]);
            }

            $this->session()->put('active_role', 'dosen');
        } else {
            $this->session()->put('active_role', $userRole);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'username' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('username')).'|'.$this->ip());
    }

    private function resolveUsername(string $identifier): string
    {
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            return Dosen::where('email', $identifier)->value('nip') ?? $identifier;
        }

        return $identifier;
    }
}
