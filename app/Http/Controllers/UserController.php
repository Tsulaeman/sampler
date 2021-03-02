<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return response([
            'users' => $users
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response([
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'string|max:255',
            'email' => 'email',
            'date_of_birth' => 'format_date:Y-m-d',
            'password' => [
                'min:8',
                'regex:/^(?=.*[0-9])(?=.*[A-Z])([a-zA-Z0-9]+)$/',
                'max:255'
            ], [
                'password.regex' => 'Password must contain atleast one number and one uppercase letter'
            ]
        ]);

        $user->fill($request->all());
        $user->password = bcrypt($request->password);
        $user->save();

        return response([
            'message' => "User updated successfully.",
            'user' => $user
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $name = $user->name;
        $user->delete();

        return response([
            'message' => "User: $name has been deleted successfully."
        ]);
    }
}
