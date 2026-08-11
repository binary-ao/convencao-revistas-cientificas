<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Fecha a sessão de imediato se a conta for desactivada por um outro
 * administrador enquanto o utilizador ainda tem sessão iniciada.
 */
class EnsureAdminIsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && ! $user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login')->withErrors([
                'email' => 'Esta conta está desactivada.',
            ]);
        }

        return $next($request);
    }
}
