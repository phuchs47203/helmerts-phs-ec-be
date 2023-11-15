<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
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
        return User::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        // check if imgurl exists 
        // after delete existed image
        // update new image

        //protect system
        $data = $request->except('role');
        $imgurl_error = "";
        $imgurl_old = $user->imgurl;
        if ($request->hasFile('imgurl')) {
            $imgurl = Cloudinary::upload($request->file('imgurl')->getRealPath())->getSecurePath();
            $imgurl_error = $imgurl;
            $data['imgurl'] = $imgurl;
        }

        try {
            $user->update($data);

            //  delete existed image
            if ($imgurl_error) {
                $token = explode('/', $imgurl_old);
                $public_ID = explode(".", $token[sizeof($token) - 1]);
                Cloudinary::destroy($public_ID[0]);
            }
        } catch (\Exception $e) {
            // delete new image uploaded
            if ($imgurl_error) {
                $token = explode('/', $imgurl_error);
                $public_ID = explode(".", $token[sizeof($token) - 1]);
                Cloudinary::destroy($public_ID[0]);
            }
            return response()->json(['error' => $e->getMessage()], 500);
        }
        $response = [
            'user' => $user,
        ];
        return response($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            return User::destroy($id);
        } catch (\Exception $e) {
            // delete new image uploaded
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
