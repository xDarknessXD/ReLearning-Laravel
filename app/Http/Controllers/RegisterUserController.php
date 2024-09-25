<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;


class RegisterUserController extends Controller
{
    public function create()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
                //validate
                $attributes = request()->validate([
                    'first_name' => ['required', 'min:3'],
                    'last_name' => ['required', 'min:3'],
                    'email' => ['required', 'email'],
                    'password' => ['required', Password::min(6), 'confirmed'],
                ]);

                //create the user
                $user =User::create($attributes);

                //login
                Auth::login($user);

                //redirect
                return redirect('/jobs');
    }
}
