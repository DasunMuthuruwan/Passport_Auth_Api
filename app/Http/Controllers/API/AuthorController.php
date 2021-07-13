<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorRequest;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorController extends Controller
{
    // CREATE REGISTER API - POST REQUEST
    public function register(AuthorRequest $request){

        // VALIDATION
        $request->validated();

        // CREATE AUTHOR
        $author = new Author();
        $author->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'phone_no' => isset($request->phone_no) ? $request->phone_no : ''
        ]);

        // $token = $author->createToken('TutsForWeb')->accessToken;

        // SEND RESPONSE
        return response()->json([
            'status' => 1,
            'message' => 'Author registered successfully',
            // 'access_token' => $token
        ]);
    }

    // CREATE LOGIN API - POST REQUEST
    public function login(Request $request){

        //VALIDATION
        $login_data = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if(Auth::attempt($login_data)){
            // GENERATE TOKEN
            $token = Auth::user()->createToken('access_token')->accessToken;

            // SEND RESPONSE
            return response()->json([
                'status' => 1,
                'message' => 'Author Logged successfully',
                'access_token' => $token
            ]);
        }

        return response()->json([
            'status' => 0,
            'message' => 'Invalide credentials'
        ],404);
    }

    // CREATE PROFILE API - GET REQUEST
    public function profile(){

        return response()->json([
            'status' => 1,
            'message' => "Get author details",
            'data' => auth()->user()
        ]);

    }

    // CREATE LOGOUT API - GET REQUEST
    public function logout(){
        // FIND CURRENT AUTHOR TOKEN
        $token = Auth::user()->token();

        $token->revoke();
        // $token->delete();
        return response()->json([
            'status' => 1,
            'message' => 'author logged out successfully'
        ]);

    }
}
