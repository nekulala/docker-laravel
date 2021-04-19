<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TweetController extends Controller
{

	public function __construct()
    {
        $this->middleware('auth');
    }

	public function index()
    {
		if ( Auth::check() ) {
			return view('home');
		} else {
			return view('welcome');
		}
    }
}
