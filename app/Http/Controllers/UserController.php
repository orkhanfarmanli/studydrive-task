<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    /**
     * Confirm the account of the user
     *
     * @param Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    
    public function confirmAccount(Request $request)
    {
        $user = User::where('register_token', $request->token)->update(['active' => 1, 'register_token' => '']);
        return redirect()->route('login');
    }
}
