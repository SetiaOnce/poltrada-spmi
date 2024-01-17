<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // return redirect()->intended(RouteServiceProvider::HOME);
        if(Auth::user()->role == 1){
            return redirect('/admin/dashboard');
        }else if(Auth::user()->role == 2){
            return redirect('/pengelola/dashboard');
        }else if(Auth::user()->role == 3){
            return redirect('/prodi/dashboard');
        }else if(Auth::user()->role == 4){
            return redirect('/asesor/dashboard');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        $notif = array(
            'message' => 'Logout Sukses !',
            'alert-type' => 'success'
        );
        return redirect('/login')->with($notif);
    }
}
