<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminUser;
use Redirect;
use Session;
use Hash;
use DB;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $user = adminuser::where('name', 'LIKE', '%' . $request->search . '%')
                            ->orWhere('fullname', 'LIKE', '%' . $request->search . '%')
                            ->get();
        } else {
            $user = DB::table('users')->orderBy('created_at', 'DESC')->get();
        }
        return view('admin-datauser', compact('user', 'request'));
    }
}