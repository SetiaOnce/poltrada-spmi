<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        if ($role == 'spm-administrator' && session()->get('key_level') != 'spm-administrator' ) {
            abort(403);
        }else if ($role == 'spm-unitprodi' && session()->get('key_level') != 'spm-unitprodi' ) {
            abort(403);
        }else if ($role == 'spm-asesor' && session()->get('key_level') != 'spm-asesor' ) {
            abort(403);
        }else if ($role == 'spm-staff' && session()->get('key_level') != 'spm-staff' ) {
            abort(403);
            
        }else{
            return $next($request);
        }
        
        
    }
}
