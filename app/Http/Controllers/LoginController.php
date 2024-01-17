<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function RedirectLogin()
    {
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
    
    public function check_login(Request $request)
    {
        $email      = $request->input('email');
        $password   = $request->input('password');

        if(Auth::guard('web')->attempt(['email' => $email, 'password' => $password])) {
            if(Auth::user()->role == 1){
                return response()->json([
                    'success' => true,
                    'email' => Auth::user()->name,
                    'role' => 1
                ], 200);
            }else if(Auth::user()->role == 2){
                return response()->json([
                    'success' => true,
                    'email' => Auth::user()->name,
                    'role' => 2
                ], 200);
            }else if(Auth::user()->role == 3){
                return response()->json([
                    'success' => true,
                    'email' => Auth::user()->name,
                    'role' => 3
                ], 200);
            }else if(Auth::user()->role == 4){
                return response()->json([
                    'success' => true,
                    'email' => Auth::user()->name,
                    'role' => 4
                ], 200);
            }
        } else{
            return response()->json([
                'error' => true,
            ], 200);
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

        return redirect('/login');
    }
}
