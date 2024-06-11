<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function redirectTo()
    {
        $role = Auth::user()->level;

        switch ($role) {
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
