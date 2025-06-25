<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DynamicMaintenance
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Ambil daftar halaman yang dalam mode maintenance dari .env
        $maintenancePages = explode(',', env('MAINTENANCE_PAGES', ''));

        // Ambil IP lokal (biasanya 127.0.0.1 atau ::1)
        $localIps = ['127.0.0.1', '::1'];
        $userIp = $request->ip();

        // Cek apakah halaman ini sedang dalam maintenance
        if (in_array($request->path(), $maintenancePages)) {
            // Jika bukan dari IP lokal, tampilkan halaman maintenance
            if (!in_array($userIp, $localIps)) {
                return response()->view('maintenance');
            }
        }

        return $next($request);
    }
}
