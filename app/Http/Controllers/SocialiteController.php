<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProvideCallback($provider)
    {
        try {

            $user = Socialite::driver($provider)->stateless()->user();
        } catch (\Exception $e) {
            return redirect()->back();
        }
        // find or create user and send params user get from socialite and provider
        $authUser = $this->findOrCreateUser($user, $provider);

        // login user
        Auth()->login($authUser, true);

        // setelah login redirect ke dashboard
        return redirect('/dashboard');
    }

    public function findOrCreateUser($socialUser, $provider)
    {
        // Get Social Account
        $socialAccount = SocialAccount::where('provider_id', $socialUser->getId())
            ->where('provider_name', $provider)
            ->first();

        // Jika sudah ada
        if ($socialAccount) {
            // return user
            return $socialAccount->user;

            // Jika belum ada
        } else {

            // User berdasarkan email 
            $user = User::where('email', $socialUser->getEmail())->first();

            // Jika Tidak ada user
            if (!$user) {
                // Create user baru
                $codeVerify = generateRandomString(15);
                $user = User::create([
                    'name'  => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'password' => Hash::make('password'),
                    'phone' => '0',
                    'balance' => 0,
                    'role_id' => 1,
                    'api_key' => implode('-', str_split(substr(strtolower(md5(microtime() . rand(1000, 9999))), 0, 30), 6)),
                    'email_verify_code' => $codeVerify
                ]);
            }

            // Buat Social Account baru
            $user->socialAccounts()->create([
                'provider_id'   => $socialUser->getId(),
                'provider_name' => $provider
            ]);

            // return user
            return $user;
        }
    }
}
