<<<<<<< HEAD
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\DashboardController;
use App\Notifications\NewSubscription;
use Illuminate\Support\Facades\Notification;


class GoogleController extends Controller
{
    //
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            $user = User::updateOrCreate(
                ['email' => $googleUser->email],
                [
                    'name' => $googleUser->name,
                    'google_id' => $googleUser->id,
                    'google_token' => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken,
                    'password' => Hash::make(Str::random(16)),
                    //'email_verified_at' => now()
                ]
            );
            
            $creado = $user->wasRecentlyCreated;
            if($creado){
                Log::debug('GoogleController.callback() Es usuario nuevo, su Avatar: ' . $googleUser->avatar);
                $user->profile_img = $googleUser->avatar;
                $user->status = 'ACTIVE';
                $user->markEmailAsVerified();
                $user->subscribeDefaultPlan();
                $user->save();
                
                Notification::route('mail', env('MAIL_USERNAME'))->notify(new NewSubscription($user));
            }
            
            if(!$user->hasVerifiedEmail()){
                Log::debug('GoogleController.callback() Usuario registrado previamente: ' . $user->email);
                $user->profile_img = $googleUser->avatar;
                $user->status = 'ACTIVE';
                $user->markEmailAsVerified();
                $user->subscribeDefaultPlan();
                $user->save();
            }
            
            Auth::login($user);
            
            if($creado){
                DashboardController::resetFilters();
            }

            return redirect()->intended('/dashboard');
            
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'google' => 'Error al autenticar con Google: ' . $e->getMessage()
            ]);
        }
    }
}



=======
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\DashboardController;
use App\Notifications\NewSubscription;
use Illuminate\Support\Facades\Notification;


class GoogleController extends Controller
{
    //
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            $user = User::updateOrCreate(
                ['email' => $googleUser->email],
                [
                    'name' => $googleUser->name,
                    'google_id' => $googleUser->id,
                    'google_token' => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken,
                    'password' => Hash::make(Str::random(16)),
                    //'email_verified_at' => now()
                ]
            );
            
            $creado = $user->wasRecentlyCreated;
            if($creado){
                Log::debug('GoogleController.callback() Es usuario nuevo, su Avatar: ' . $googleUser->avatar);
                $user->profile_img = $googleUser->avatar;
                $user->status = 'ACTIVE';
                $user->markEmailAsVerified();
                $user->subscribeDefaultPlan();
                $user->save();
                
                Notification::route('mail', env('MAIL_USERNAME'))->notify(new NewSubscription($user));
            }
            
            if(!$user->hasVerifiedEmail()){
                Log::debug('GoogleController.callback() Usuario registrado previamente: ' . $user->email);
                $user->profile_img = $googleUser->avatar;
                $user->status = 'ACTIVE';
                $user->markEmailAsVerified();
                $user->subscribeDefaultPlan();
                $user->save();
            }
            
            Auth::login($user);
            
            if($creado){
                DashboardController::resetFilters();
            }

            return redirect()->intended('/dashboard');
            
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'google' => 'Error al autenticar con Google: ' . $e->getMessage()
            ]);
        }
    }
}



>>>>>>> 0d6f5c2c18f02c9c7d0a3cb40a1c8218e42ba08f
