<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Exception;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        try {
            $obj = new User();
            $users = $obj->all();

            return [
                'status' => 1,
                'data' => $users
            ];

        } catch (Exception $e){

            return [
                "status" => 0,
                "error" => $e->getMessage(),
            ];

        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {

        try {
            
            $obj = new User();
            $user = $obj->create($request->all());

            return [
                'status' => 1,
                'data' => $user
            ];

        } catch (Exception $e){

            return [
                "status" => 0,
                "error" => $e->getMessage(),
            ];

        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        try {

            return [
                "status" => 1,
                "data" => $user
            ];

        } catch (Exception $e){

            return [
                "status" => 0,
                "error" => $e->getMessage(),
            ];

        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            $user->update($request->all());

            return [
                "status" => 1,
                "data" => $user
            ];

        } catch (Exception $e){

            return [
                "status" => 0,
                "error" => $e->getMessage()
            ];
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {

            $user->delete();

            return [
                "status" => 1,
                "data" => $user
            ];

        } catch (Exception $e){

            return [
                "status" => 1,
                "error" => $e->getMessage()
            ];

        }
    }

    public function login(LoginRequest $request){

        $input = $request->all();

        $credentials = [
            "username" => $input["username"],
            "password" => $input["password"]
        ];

        if (auth()->attempt($credentials)) {

            $usuario = auth()->user();
            $token = $usuario->createToken('Library')->accessToken;

            return response()->json([
                "status" => true,
                "token" => $token,
                "escopo" => auth()->user()->user_type->description
            ], 200);

        } else {

            return response()->json([
                "status" => false,
                'error' => 'You are not allowed to make this request.'
            ], 401);

        };
    }

    public function logout()
    {
        if (auth()->check()) {
            auth()->user()->token()->revoke();

            return response()->json([
                'status' => true,
                'message' => 'Logout successful.'
            ], 200);

        } else {
            return response()->json([
                'status' => false,
                'error' => 'Logout error. Maybe your token was already revoked. Please try again if thats not the case.'
            ], 500);
        }
    }
}
