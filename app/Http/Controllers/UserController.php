<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function login(Request $request)
    {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])){
            return response()->json([
                'success' => true,
                'data' => $user = Auth::user()
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Credentials.'
            ]);
        }


        /* // get user
        $user = User::where('username', $request->username)->first();
        // check if user exists
        if ($user) {
            // check if password is correct
            if ($user->password == md5($request->password)) {
                return response()->json([
                    'success' => true,
                    'data' => $user
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Incorrect password.'
                ]);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User does not exist.'
            ]);
        } */
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all users
        $users = User::all();
        return response()->json($users, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // create a new user
        $user = new User();
        $user->username = $request->username;
        $user->password = Hash::make($request->password); 
        $user->role = $request->role;
        $user->first_name = $request->first_name;
        $user->middle_name = $request->middle_name;
        $user->last_name = $request->last_name;
        $user->learner_s_id = $request->learner_s_id;
        $user->contact_number = $request->contact_number;
        $user->grade_level = $request->grade_level;
        $user->section = $request->section;
        $user->school_year = $request->school_year;
        $user->status = $request->status;
        $user->save();
        return response()->json([
            'message' => 'User successfully created.',
            'data' => $user
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // get certain user
        return response()->json($user, 200);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // update a user 
        $user->username = $request->username;
        $user->password = $request->password?Hash::make($request->password):$user->password;
        $user->role = $request->role;
        $user->first_name = $request->first_name;
        $user->middle_name = $request->middle_name;
        $user->last_name = $request->last_name;
        $user->learner_s_id = $request->learner_s_id;
        $user->contact_number = $request->contact_number;
        $user->grade_level = $request->grade_level;
        $user->section = $request->section;
        $user->school_year = $request->school_year;
        $user->status = $request->status;
        $user->save();
        return response()->json([
            'message' => 'User successfully updated.',
            'data' => $user
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // delete a user
        $user->delete();
        return response()->json([
            'message' => 'User successfully deleted.',
            'data' => $user
        ], 200);

    }
}
