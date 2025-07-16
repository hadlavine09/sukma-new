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

    if (! $user) {
        return '/';
    }

    // Ambil role user dari relasi role_user
    $role = DB::table('role_user')
        ->where('user_id', $user->id)
        ->join('roles', 'role_user.role_id', '=', 'roles.id')
        ->select('roles.name')
        ->first();

    if (! $role) {
        return '/';
    }

    $roleName = $role->name;

    // Default redirect
    $redirect = '/';

    if ($roleName === 'toko') {
        $toko = DB::table('tokos')
            ->where('pemilik_toko_id', $user->id)
            ->whereNull('deleted_at')
            ->orderByDesc('id')
            ->first();

        if ($toko) {
            switch ($toko->status_toko) {
                case 'belum_beres':
                    $redirect = route('verifikasitoko');
                    break;
                case 'proses':
                case 'tidak_diizinkan':
                    $redirect = route('verifikasi_toko.wait');
                    break;
                case 'izinkan':
                    $redirect = route('dashboard');
                    break;
                default:
                    $redirect = '/';
            }
        } else {
            // Jika belum ada toko sama sekali, arahkan ke awal verifikasi
            $redirect = route('verifikasitoko');
        }
    } elseif (in_array($roleName, ['admin', 'superadmin'])) {
        $redirect = route('dashboard');
    } elseif ($roleName === 'user') {
        $redirect = '/';
    }

    return $redirect;
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
        // dd($request->all());
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
        return redirect($this->redirectTo());
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
