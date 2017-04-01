<?php

namespace App\Http\Controllers;
use Auth;
use Mail;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'only' => ['edit', 'update', 'destroy']
            ]);
        $this->middleware('guest',[
            'only' => ['create']
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
        $this->sendEmailConfirmationTo($user);
        session()->flash('success', 'Verify email has been sent to your registered email, please check it.');
        return redirect('/');
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
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', 'Delete successfully!');
        return back();
    }

    protected function sendEmailConfirmationTo($user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        $from = '744585345@qq.com';
        $name = 'WangShawn';
        $to = $user->email;
        $subject = 'Thank you for registering! Please confirm your email address.';

        Mail::send($view, $data, function ($message) use($from, $name, $to, $subject)
        {
            $message->from($from, $name)->to($to)->subject($subject);
        });
    }
    public function confirmEmail($token)
    {
        $user = User::where('activation_token', $token)->firstOrFail();
        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user);
        session()->flash('success', 'Activation success!');

        return redirect()->route('users.show', [$user]);
    }
}
