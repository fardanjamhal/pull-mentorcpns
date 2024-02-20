<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Inertia\Inertia;
use App\Models\Setting;
use App\Models\User;
use Hash;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::authenticateUsing(function (Request $request) {
            $setting = Setting::first();
            if($setting && $setting->login_type == 3) {
                $user = User::where('email', $request->email)->orWhere('username', $request->email)->first();
            } elseif($setting && $setting->login_type == 2) {
                $user = User::where('username', $request->email)->first();
            } else {
                $user = User::where('email', $request->email)->first();
            }

            if ($user &&
                Hash::check($request->password, $user->password)) {
                return $user;
            }
        });

        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(5)->by($email.$request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        // login
        Fortify::loginView(function() {
            return Inertia::render('Auth/Login');
        });

        // register
        Fortify::registerView(function() {
            return Inertia::render('Auth/Register');
        });

        /**
         * logout
         */
        $this->app->singleton(\Laravel\Fortify\Contracts\LogoutResponse::class,\App\Http\Responses\LogoutResponse::class);
    }
}
