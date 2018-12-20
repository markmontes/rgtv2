<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\User;

class AccountsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index() {
        $users = User::OrderBy('name', 'Asc')
        ->get();

        return view('accounts.index')
        ->with(compact('users'));
    }



}
