<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getUsers(Request $request){
        return response()->json(User::paginate(15));
    }

    public function postUser(Request $request){
        $this->validate($request,[
            'email' => 'unique:users'
        ]);

        return response()->json(User::create($request->all()));
    }

    public function getUser(Request $request, int $id){
        return response()->json(User::find($id));
    }

    public function putUser(Request $request, int $id){
        $user = User::find($id);
        $user->update($request->all());
        return response()->json($user);
    }

    public function deleteUser(Request $request, int $id){
        return response()->json(User::find($id)->delete());
    }
}
