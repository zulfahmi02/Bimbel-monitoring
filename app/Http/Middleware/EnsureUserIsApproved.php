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
        $user = Auth::user();

        if ($user && $user->status !== 'approved') {
            Auth::logout();

            return redirect()->route('welcome')->with('error', 'Akun Anda belum disetujui oleh Admin. Silahkan hubungi Admin atau tunggu persetujuan.');
        }

        return $next($request);
    }
}
