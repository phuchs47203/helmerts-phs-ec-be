<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
            'phone_number' => 'string',
            'country' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'address_details' => 'required|string',
            'imgurl' => 'image|required',
            'dateofbirth' => 'date',
            'title' => 'required|string',
        ]);
        // $imgurl = Cloudinary::upload(($fields['imgurl'])->getRealPath())->getSecurePath();

        $imgurl = Cloudinary::upload($request->file('imgurl')->getRealPath())->getSecurePath();
        // return ($imgurl);
        $user = User::create([
            'first_name' => $fields['first_name'],
            'last_name' => $fields['last_name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'phone_number' => $fields['phone_number'],
            'country' => $fields['country'],
            'city' => $fields['city'],
            'district' => $fields['district'],
            'address_details' => $fields['address_details'],
            'imgurl' => $imgurl,
            'role' => 'user',
            'dateofbirth' => $fields['dateofbirth'],
            'title' => $fields['title'],
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;
        $response  = [
            'user' => $user,
            'token' => $token
        ];
        // 'imgurl' => 'image|dimensions:ratio=1/1',
        return response($response, 201);
    }
    public function register_shipper(Request $request)
    {
        $fields = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
            'phone_number' => 'string',
            'country' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'address_details' => 'required|string',
            'imgurl' => 'image|required',
            'dateofbirth' => 'date',
            'title' => 'required|string',
        ]);
        // $imgurl = Cloudinary::upload(($fields['imgurl'])->getRealPath())->getSecurePath();

        $imgurl = Cloudinary::upload($request->file('imgurl')->getRealPath())->getSecurePath();
        // return ($imgurl);
        $user = User::create([
            'first_name' => $fields['first_name'],
            'last_name' => $fields['last_name'],
            'password' => bcrypt($fields['password']),
            'phone_number' => $fields['phone_number'],
            'country' => $fields['country'],
            'city' => $fields['city'],
            'district' => $fields['district'],
            'address_details' => $fields['address_details'],
            'imgurl' => $imgurl,
            'role' => 'shipper',
            'dateofbirth' => $fields['dateofbirth'],
            'title' => $fields['title'],
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;
        $response  = [
            'user' => $user,
            'token' => $token
        ];
        // 'imgurl' => 'image|dimensions:ratio=1/1',
        return response($response, 201);
    }
    public function register_manager(Request $request)
    {
        $fields = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
            'phone_number' => 'string',
            'country' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'address_details' => 'required|string',
            'imgurl' => 'image|required',
            'dateofbirth' => 'date',
            'title' => 'required|string',
        ]);
        // $imgurl = Cloudinary::upload(($fields['imgurl'])->getRealPath())->getSecurePath();

        $imgurl = Cloudinary::upload($request->file('imgurl')->getRealPath())->getSecurePath();
        // return ($imgurl);
        $user = User::create([
            'first_name' => $fields['first_name'],
            'last_name' => $fields['last_name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            'phone_number' => $fields['phone_number'],
            'country' => $fields['country'],
            'city' => $fields['city'],
            'district' => $fields['district'],
            'address_details' => $fields['address_details'],
            'imgurl' => $imgurl,
            'role' => 'manager',
            'dateofbirth' => $fields['dateofbirth'],
            'title' => $fields['title'],
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;
        $response  = [
            'user' => $user,
            'token' => $token
        ];
        // 'imgurl' => 'image|dimensions:ratio=1/1',
        return response($response, 201);
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccesstoken()->delete();
        return [
            'message' => 'logged out'
        ];
    }
    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
        $user = User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad creds'
            ], 401);
        }
        $token = $user->createToken('myapptoken')->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response($response, 201);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
