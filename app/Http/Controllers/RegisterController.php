<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RegisterController extends Controller
{
    public function index()
    {
        
        return view('user.register');
    }

    public function add_account(Request $request)
    {
        
        $input = $request->except(['_token', 'password_confirm']);
        
        $User = new User;
        $User->name = $input['name'];
        $User->email = $input['email'];
        $User->password = Hash::make( $input['password'] );


        $User->save();

        return redirect()->route('login');
    }
}
