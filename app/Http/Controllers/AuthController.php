<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;


class AuthController extends Controller
{
    /**
     * Store a new user
     * @param Request $request
     * @return Response
     */
    public function register(Request $request)
    {
        // validar los datos de la peticion
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|confirmed',
        ]);

        try {
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = app('hash')->make($request->password);

            $user->save();

            return response()->json(['user' => $user, 'message' => 'Usuario Creado'], 201 );
        } catch (Exception $e) {
            return response()->json(['message' => 'Ocurrio un error intenta nuevamente!'], 409);
        }
    }

    /**
     * Get a JWT via given credentials
     * @param Request $request 
     * @return Response
     */
    public function login(Request $request) 
    {
        // Validate data in request
        $this->validate($request, [
            'email'    => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);

    }
}
