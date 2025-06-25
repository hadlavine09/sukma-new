<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

  public function handleGoogleCallback()
{
    $googleUser = Socialite::driver('google')->stateless()->user();

    // Cari user berdasarkan email
    $user = User::where('email', $googleUser->getEmail())->first();

    if (!$user) {
        // Jika user belum ada, buat baru dan berikan role 1
        $user = User::create([
            'name' => $googleUser->getName(),
            'username' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'google_id' => $googleUser->getId(),
            'avatar' => $googleUser->getAvatar(),
        ]);

        // Assign role ID 1
        $user->roles()->sync([1]);
    } else {
        // Jika user sudah ada, update data Google-nya
        $user->update([
            'name' => $googleUser->getName(),
            'username' => $googleUser->getName(),
            'google_id' => $googleUser->getId(),
            'avatar' => $googleUser->getAvatar(),
        ]);
    }

    // Login user
    Auth::login($user);

    // Redirect ke halaman home
    return redirect('/Home');
}


}
