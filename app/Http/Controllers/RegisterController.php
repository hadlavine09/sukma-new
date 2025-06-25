<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
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
        return view('toko.auth.register');
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
        $user = \App\Models\User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Login user setelah registrasi
        auth()->login($user);

        return redirect()->route('verifikasitoko')->with('success', 'Registration successful!');
    }
    public function registertoko(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        DB::beginTransaction();

        try {
            // Buat user baru
            $user = User::create([
                'username' => $validated['username'],
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
