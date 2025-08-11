<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function index()
    {
        if (!session('is_logged_in')) {
            return redirect('/login');
        }
        return view('dashboard');
    }
}