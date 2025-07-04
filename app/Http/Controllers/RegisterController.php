<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laratrust\Models\Role;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function showRegisterToko()
    {
        return view('auth.registertoko');
    }

    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Buat user baru
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password), // pastikan di-hash
        ]);

        // Login otomatis
        Auth::login($user);

        // Redirect ke beranda
        return redirect(url('/'))->with('success', 'Registrasi berhasil! Anda sudah login.');
    }
    public function registertoko(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        DB::beginTransaction();

        try {
            // Buat user baru
            $user = User::create([
                'email'    => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            // Ambil role 'toko'
            $role = Role::where('name', 'toko')->firstOrFail();

            // Assign role menggunakan Laratrust
            $user->roles()->attach($role->id);

            DB::commit();

            // Login user
            auth()->login($user);

            // Redirect ke route 'verifikasitoko'
            return redirect()->route('verifikasitoko')->with('success', 'Registrasi berhasil sebagai penjual.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal register toko: ' . $e->getMessage());

            return redirect()->back()->withErrors(['register' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

}
