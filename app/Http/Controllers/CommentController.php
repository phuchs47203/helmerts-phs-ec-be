<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\Comment;
use App\Models\Product;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Comment::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            $fields = $request->validate([
                'cus_id' => 'required',
                'product_id' => 'required',
                'star' => 'required',
                'content' => 'required|string',
                'imgurl' => 'image'
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage(), 'errors' => $e->errors()], 422);
        }
        if ($request->hasFile('imgurl')) {
            $imgurl = Cloudinary::upload($request->file('imgurl')->getRealPath())->getSecurePath();
            $comment = Comment::create([
                'cus_id' => $fields['cus_id'],
                'product_id' => $fields['product_id'],
                'star' => $fields['star'],
                'content' => $fields['content'],
                'imgurl' => $imgurl
            ]);
            return response($comment, 201);
        }
        $comment = Comment::create([
            'cus_id' => $fields['cus_id'],
            'product_id' => $fields['product_id'],
            'star' => $fields['star'],
            'content' => $fields['content'],
            'imgurl' => null
        ]);
        return response($comment, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $comment = Comment::find($id);
        return  $comment->productComments;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $comment = Comment::find($id);
        // check if imgurl exists 
        // after delete existed image
        // update new image
        $data = $request->all();
        $imgurl_error = "";
        $imgurl_old = $comment->imgurl;
        if ($request->hasFile('imgurl')) {
            $imgurl = Cloudinary::upload($request->file('imgurl')->getRealPath())->getSecurePath();
            $imgurl_error = $imgurl;
            $data['imgurl'] = $imgurl;
        }
        try {
            $comment->update($data);
            //  delete existed image
            if ($imgurl_error) {
                $token = explode('/', $imgurl_old);
                $public_ID = explode(".", $token[sizeof($token) - 1]);
                Cloudinary::destroy($public_ID[0]);
            }
        } catch (\Exception $e) {
            // delete new image uploaded when error
            if ($imgurl_error) {
                $token = explode('/', $imgurl_error);
                $public_ID = explode(".", $token[sizeof($token) - 1]);
                Cloudinary::destroy($public_ID[0]);
            }
            return response()->json(['errors' => $e->getMessage()], 500);
        }
        $response = [
            'comment' => $comment,
        ];
        return response($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return Comment::destroy($id);
    }
}
