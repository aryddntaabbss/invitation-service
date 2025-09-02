<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    /**
     * Redirect to Google OAuth
     */
    public function redirectToGoogle()
    {
        try {
            Log::info('Redirecting to Google...');
            return Socialite::driver('google')->redirect();
        } catch (\Exception $e) {
            Log::error('Google redirect error: ' . $e->getMessage());
            return redirect()->route('customer.login')
                ->withErrors(['error' => 'Tidak dapat redirect ke Google.']);
        }
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Cari customer berdasarkan email atau google_id
            $customer = Customer::where('email', $googleUser->getEmail())
                ->orWhere('google_id', $googleUser->getId())
                ->first();

            if (!$customer) {
                // Buat customer baru - REGISTER
                $customer = Customer::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => Hash::make(Str::random(16)),
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'status' => 'active',
                ]);
            } else {
                // UPDATE existing customer - LOGIN
                $customer->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                    'last_login_at' => now(),
                    'last_login_ip' => request()->ip(),
                ]);
            }

            Auth::guard('customer')->login($customer);

            return redirect()->route('customer.dashboard');
        } catch (\Exception $e) {
            logger()->error('Google login error: ' . $e->getMessage());
            return redirect()->route('customer.login')
                ->withErrors(['error' => 'Login dengan Google gagal. Silakan coba lagi.']);
        }
    }

    /**
     * Redirect to other social providers (untuk future expansion)
     */
    public function redirectToProvider($provider)
    {
        if (!in_array($provider, ['google', 'facebook', 'github'])) {
            return redirect()->route('customer.login')
                ->withErrors(['error' => 'Provider tidak didukung.']);
        }

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Handle other social providers callback
     */
    public function handleProviderCallback($provider)
    {
        if (!in_array($provider, ['google', 'facebook', 'github'])) {
            return redirect()->route('customer.login')
                ->withErrors(['error' => 'Provider tidak didukung.']);
        }

        try {
            $socialUser = Socialite::driver($provider)->user();

            $customer = Customer::where('email', $socialUser->getEmail())->first();

            if (!$customer) {
                $customer = Customer::create([
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'password' => Hash::make(Str::random(16)),
                    'status' => 'active',
                    'avatar' => $socialUser->getAvatar(),
                ]);
            }

            Auth::guard('customer')->login($customer);

            return redirect()->route('customer.dashboard');
        } catch (\Exception $e) {
            return redirect()->route('customer.login')
                ->withErrors(['error' => "Login dengan {$provider} gagal. Silakan coba lagi."]);
        }
    }
}
