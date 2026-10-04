<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PosDashboardController extends Controller
{
    public function pos_dashboard(Request $request)
    {
        if ($request->session()->get('pos_logged_in') !== true) {
            return redirect('/pos_login');
        }

        return view('pos/pos_dashboard');
    }
}
