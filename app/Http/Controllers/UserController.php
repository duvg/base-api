<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    /**
     * New instance UserController
     *
     * @return void
     */
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Get all users
     *
     * @return Response
     */
    public function index()
    {
        $users = User::all();
        return response()->json(['users' => User::all(), 200]);
    }

    /**
     * Get authenticated user data
     * 
     * @return Response
     */
    public function profile()
    {
        return response()->json(['user' => Auth::user()], 200);
    }


    /**
     * Get one user by id
     *
     * @params Request $id
     * @return Response
     */
    public function getUser($id)
    {
        try 
        {
            $user = User::findOrFail($id);
            return response()->json(['user' => $user], 200);    
        } catch (Exception $e) {
            return response()->json(['message' => 'user nor found'], 404);
        }
    }

    
}
