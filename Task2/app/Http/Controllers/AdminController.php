<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function adminrRegister(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = Admin::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => Hash::make($fields['password'])
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function adminLogin(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);


        // check email
        $user = Admin::where('email', $fields['email'])->first();

        // check password
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad creds'
            ], 401);
        }
        // create access token
        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function adminLogout(Request $request)
    {
        Auth::user()->tokens()->delete();

        return [
            'message' => 'Admin Logged out'
        ];
    }

    public function viewUser(){
        $users = User::all();
        return response($users, 201);
    }

    public function userUpdate($id){
        $user = User::find($id);
        
        $user->update([
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'division' => $_POST['division']
        ]);

        return response($user, 201);
    }

    public function userDestroy($id)
    {
        return User::destroy($id);
    }

    public function userFilter(Request $request, User $user){
        if ($request->has('division')) {
            return $user->where('division', $request->input('division'))->get();
        }
        if ($request->has('email')) {
            $admin = new Admin();
            // to extract email
            $extract_email = $admin->extract_emails_from($request->input('email'));
            return $user->where('email', $extract_email)->get();
        }
    }
}
