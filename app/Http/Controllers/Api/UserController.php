<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        return response()->json([
            'totalelements' => count($users),
            'data' => $users
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'username' => ['required', 'unique:users,username', 'min:4', 'max:60'],
            'password' => ['required', 'min:5', 'max:20']
        ]);

        // mencari username di tabel user 
        $existingUser = User::where('username', $request->username)->first();
            
        // mengecek dengan if apakah hasilnya true atau false 
        // return response dengan message username already exists (manual)
        if($existingUser){
            return response()->json([
                'status' => 'failed',
                'message' => 'Username sudah tersedia'
            ], 400);
        }

        // kondisi apabila validasi gagal, (otomatis)
        if($validated->fails()){
            return response()->json([
                'status' => 'invalid',
                'message' => $validated->errors(),
            ], 400);
        }

        // jika validasi berhasil, hash password dan buat akunnya
        $data_user = $validated->validate();
        $data_user['password'] = Hash::make($data_user['password']);

        $user = User::create($data_user);

        // buat token aces
        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'username' => $user->username
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = Validator::make($request->all(), [
            'username' => ['required', 'unique:users,username', 'min:4', 'max:60'],
            'password' => ['required', 'min:5', 'max:20']
        ]);

        // if($validated->fails()){
        //     return response()->json([
        //         'status' => 'invalid',
        //         'message' => $validated->errors(),
        //     ], 400);
        // }

        $user = User::find($id);

        if(!$user){
            return response()->json([
                'status' => 'not found',
                'message' => 'user does not axist'
            ], 404);
        }

        $user['username'] = $request->username;

        $user['password'] = Hash::make($request->password);

        $user->update();

        return response()->json([
            'status' => 'succes',
            'username' => $user->username
        ]);




    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);

        if(!$user){
            return response()->json([
                'status' => 'not found',
                'message' => 'User not found'
            ], 403);
        }

        $user->delete();

        

        return response()->json([], 204);

    }
}