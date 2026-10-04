<?php

namespace App\Http\Controllers;

use App\Models\Pos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PosAuthController extends Controller
{
    public function pos_login(Request $request)
    {
        if ($request->session()->get('pos_logged_in') === true) {
            return redirect('/pos_dashboard');
        }

        return view('pos/auth/login');
    }

    public function pos_login_success(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $pos = Pos::where('username', $request->username)->first();

        if (!$pos || !Hash::check($request->password, $pos->password)) {
            return back()
                ->withInput($request->only('username'))
                ->with('error', 'Invalid username or password.');
        }

        if ($pos->account_Status !== 'active') {
            return back()
                ->withInput($request->only('username'))
                ->with('error', 'Your POS account is inactive.');
        }

        $pos->last_login_date_time = now();
        $pos->save();

        $request->session()->regenerate();

        $request->session()->put([
            'pos_logged_in' => true,
            'pos_id' => $pos->pos_id,
            'pos_name' => $pos->name,
            'pos_username' => $pos->username,
            'pos_last_login_date_time' => $pos->last_login_date_time,
        ]);

        return redirect('/pos_dashboard')
            ->with('success', 'Welcome back, ' . $pos->name . '!');
    }
}