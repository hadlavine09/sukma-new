<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    protected function redirectTo()
    {
        $user = Auth::user();

        // Ambil role user dari tabel role_user
        $role = DB::table('role_user')
            ->where('user_id', $user->id)
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->value('roles.name');

        // Jika role adalah 'toko', cek status toko
        if ($role === 'toko') {
            $toko = DB::table('tokos')
                ->where('pemilik_toko_id', $user->id)
                ->whereNull('deleted_at')
                ->orderByDesc('id')
                ->first();

            if ($toko) {
                if (in_array($toko->status_toko, ['proses', 'tidak_diizinkan'])) {
                    return '/verifikasi-toko/wait';
                } elseif ($toko->status_toko === 'izinkan') {
                    return '/dashboard-toko';
                }
            }

            // Jika belum pernah mengajukan toko
            return '/verifikasi-toko/wait';
        }

        // Redirect default untuk role lainnya
        return match ($role) {
            'superadmin', 'admin' => '/dashboard-admin',
            'user'                => '/Home',
            default               => '/',
        };
    }

    public function showLoginForm()
    {
        return Auth::check() ? redirect($this->redirectTo()) : view('auth.login');
    }
    public function showLoginToko()
    {
        return Auth::check() ? redirect($this->redirectTo()) : view('toko.auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect($this->redirectTo());
        }

        return back()->withErrors(['login' => 'Username atau password salah.'])->withInput();
    }
    public function logintoko(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect($this->redirectTo());
        }

        return back()->withErrors(['login' => 'Username atau password salah.'])->withInput();
    }
    public function logout(Request $request)
    {
        Auth::logout();

        // Optional, lebih aman
        Session::invalidate();
        Session::regenerateToken();
        // Hapus sesi pengguna dan regenerasi token CSRF
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman login menggunakan named route
        return redirect()->route('login');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
