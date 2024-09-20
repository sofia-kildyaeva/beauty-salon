<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(Request $request) {
        $user = User::query()
            ->where('login', $request->login)
            ->where('password', md5($request->password))
            ->first();
        if ($user) {
            Auth::login($user);
            return redirect()->route('CategoryTypePage');
        }
        return response()->json('Неверные данные', 403);
    }

    public function ExitUser() {
        Auth::logout();
        return redirect()->route('welcome');
    }
}
