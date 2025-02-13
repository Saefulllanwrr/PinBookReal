<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AkunController extends Controller
{
    public function index()
    {
        $users = Auth::user();
        return view('akun.index', compact('users'));
    }
}
