<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'only' => ['edit', 'update']
            ]);
    }
    public function index()
    {
        $users = User::paginate(30);

        return view('users.index', compact('users'));
    }
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
        Auth::login($user);
        session()->flash('success', 'Welcome! You have registered successfully!');
        return redirect()->route('users.show', [$user]);
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:50',
            'password' => 'confirmed|min:6|max:12'
            ]);
        $user = User::findOrFail($id);
        $this->authorize('update', $user);

        $data = [];
        $data['name'] = $request->name;
        if($request->password){
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);
        
        session()->flash('success', 'Update successfully!');

        return redirect()->route('users.show', $id);
    }
}
