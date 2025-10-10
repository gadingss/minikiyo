<?php

namespace App\Http\Responses;

use Filament\Http\Responses\Auth\LoginResponse as BaseLoginResponse;
use Illuminate\Support\Facades\Auth;

class LoginResponse extends BaseLoginResponse
{
    public function toResponse($request)
    {
        $user = Auth::user();

        if ($user && $user->usertype === 'admin') {
            // Admin ke dashboard Filament
            return redirect()->intended('/admin');
        }

        // Selain admin (customer) ke beranda
        return redirect()->intended('/');
    }
}
