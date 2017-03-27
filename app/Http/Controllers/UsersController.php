<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    //
    public function create()
    {
    	return view('users.create');
    }

    public function show($id)
    {
    	$user = User::findOrFail($id);
    	return view('users.show', compact('user'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:6|max:12|confirmed'
            ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
            ]);
        session()->flash('success', 'Welcome! You have registered successfully!');
        return redirect()->route('users.show', [$user]);
    }
}
