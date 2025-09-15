<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function throttleKey(Request $request): string
    {
        return Str::lower($request->input('email')).'|'.$request->ip();
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required','email'],
            'password' => ['required','string'],
            'remember' => ['sometimes','boolean'],
        ]);

        if (RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            return response()->json([
                'message' => 'Demasiados intentos. Intenta nuevamente en un minuto.'
            ], 429);
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            RateLimiter::clear($this->throttleKey($request));

            return response()->json([
                'success'  => true,
                'redirect' => url()->previous() === url()->current()
                    ? route('dashboard')
                    : redirect()->intended(route('dashboard'))->getTargetUrl(),
            ], 200);
        }

        RateLimiter::hit($this->throttleKey($request), 60);

        return response()->json([
            'message' => 'Credenciales inválidas.'
        ], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); // o response()->json(['success' => true])
    }
}
