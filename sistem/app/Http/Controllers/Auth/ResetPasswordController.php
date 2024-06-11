<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected function redirectTo()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Check user level
        switch ($user->level) {
            case 'admin':
            case 'owner':
                return RouteServiceProvider::HOME;
                break;
            case 'apoteker':
                return '/kasir';
                break;
            case 'pelanggan':
                return '/';
                break;
            default:
                return RouteServiceProvider::HOME;
        }
    }
}
