<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Pelanggan;
use Hash;
use Redirect;
use Session;

class ProfilKasirController extends Controller
{
    public function index()
    {
        $pelanggan = Pelanggan::findOrFail(Auth::id());

        return view('/editprofil-kasir', compact('pelanggan'));
    }

    public function update(Request $request, $id)
    {
        $pelanggan = Pelanggan::find($id);

        $pelanggan->name = $request->name;
        $pelanggan->email = $request->email;

        if ($request->filled('old_password')) {
            if (Hash::check($request->old_password, $pelanggan->password)) {
                $pelanggan->update([
                    'password' => Hash::make($request->password)
                ]);
            } else {
                return back()
                    ->withErrors(['old_password' => __('Please enter the correct password')])
                    ->withInput();
            }
        }

        $pelanggan->save();
        return redirect('/editprofil-kasir')->with('message', 'Profil berhasil diupdate')->with('alert_class', 'success');
    }
}