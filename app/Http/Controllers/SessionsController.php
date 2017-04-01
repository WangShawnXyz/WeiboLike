<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;

class SessionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', [
            'only' => ['create']
            ]);
        $this->middleware('auth', [
            'only' => ['edit', 'update']
            ]);
    }

    public function create()
    {
    	return view('sessions.create');
    }
    public function store(Request $request)
    {
    	$this->validate($request, [
    		'email' => 'required|email|max:255',
    		'password' => 'required'
    		]);
    	$credentials = [
    		'email' => $request->email,
    		'password' => $request->password
    	];
    	if (Auth::attempt($credentials, $request->has('remember'))) {
    		# success... 
            if (Auth::user()->activated) {
               session()->flash('success', 'Welcome!');
            return redirect()->intended(route('users.show', [Auth::user()]));
            } else {
                Auth::logout();
                session()->flash('warning', 'Your account is not activated, please check the registered mail in the mailbox to activated.');
                return redirect('/');
            }
            
    		
    	} else {
    		# failed...
    		session()->flash('danger', 'Unmatched username and password!');
    		return redirect()->back();
    	}
    }
    public function destroy()
    {
        Auth::logout();
        session()->flash('success', 'You have sign out successfully!');
        return redirect('login');
    }
}
