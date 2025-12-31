<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsApproved
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Deteksi guard yang sedang aktif
        $guards = ['parent', 'teacher', 'web'];
        $user = null;
        $activeGuard = null;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                $activeGuard = $guard;
                break;
            }
        }

        // Validasi status approval
        if ($user && $user->status !== 'approved') {
            Auth::guard($activeGuard)->logout();
            
            // Redirect ke halaman login yang sesuai
            $loginRoute = match($activeGuard) {
                'teacher' => 'teacher.login',
                'parent' => 'parent.login',
                default => 'landing'
            };
            
            return redirect()->route($loginRoute)
                ->with('error', 'Akun Anda belum disetujui oleh Admin. Silahkan hubungi Admin atau tunggu persetujuan.');
        }

        return $next($request);
    }
}
