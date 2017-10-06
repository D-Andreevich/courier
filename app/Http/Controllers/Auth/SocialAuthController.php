<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;
use App\User;
use Illuminate\Support\Facades\Auth;

class SocialAuthController extends Controller
{
    public function redirectToProvider_facebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleProviderCallback_facebook()
    {
        $fasebookUser = Socialite::driver('facebook')->user();

        $dataUser = [
            'social_id' => $fasebookUser->id,
            'phone' => 'null',
            'name' => $fasebookUser->name,
            'email' => $fasebookUser->email,
            'avatar' => $fasebookUser->avatar_original,
        ];

        $user = User::where('social_id', $dataUser['social_id'])->first();

        if (is_null($user)) {
            return view('auth/socialAuth')->with('user', $dataUser);
        } else {
            Auth::login($user, true);
            return view('/home');
        }

    }

    public function redirectToProvider_google()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback_google()
    {
        $googleUser = Socialite::driver('google')->user();

        $dataUser = [
            'social_id' => $googleUser->id,
            'phone' => 'null',
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'avatar' => $googleUser->avatar_original,
        ];

        $user = User::where('social_id', $dataUser['social_id'])->first();

        if (is_null($user)) {
            return view('auth/socialAuth')->with('user', $dataUser);
        } else {
            Auth::login($user, true);
            return view('/home');
        }
    }

    public function saveAuthSocial(Request $request)
    {
        $dataUser = [
            'social_id' => $_POST['social_id'],
            'phone' => $_POST['phone'],
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'avatar' => $_POST['avatar'],
        ];

        dump($dataUser);

        $user = new User($dataUser);
        $user->save();

        Auth::login($user, true);

        return view('/home');
    }
}
