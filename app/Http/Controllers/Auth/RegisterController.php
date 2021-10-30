<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\VerifyMail;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }
    public function store(Request $request)
    {
        //validate
        $this->validate($request, [
            'name' => 'required|max:255',
            'username' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|confirmed'
        ]);
        //store user
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'remember_token' => Hash::make(Str::random(60)),
        ]);
        //sign user indd
        Mail::to($request->user())->send(new VerifyMail($user->remember_token));
        // auth()->attempt($request->only('email', 'password'));
        //redirect
        return new VerifyMail($user->remmeber_token);
    }
    public function verifyUser($remmeber_token)
    {
        $verifyUser = User::where('remmeber_token', $remmeber_token)->first();
        if (isset($verifyUser)) {
            // $user = $verifyUser->user;
            // if (!$user->verified) {
            //     $verifyUser->user->verified = 1;
            //     $verifyUser->user->save();
            //     $status = "Your e-mail is verified. You can now login.";
            // } else {
            //     $status = "Your e-mail is already verified. You can now login.";
            // }
            auth()->attempt($verifyUser->email, $verifyUser->password);
            return redirect()->route('dashboard')->with('status', 'success!!!');
        } else {
            return redirect()->route('dashboard')->with('status', "Sorry your email cannot be identified.");
        }
        return redirect('/login')->with('status', $status);
    }
}
