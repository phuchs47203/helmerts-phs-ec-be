<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use JeroenG\Explorer\Domain\Syntax\Matching;
use JeroenG\Explorer\Domain\Syntax\Term;
use JeroenG\Explorer\Domain\Syntax\Terms;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Product::query()->update([
            'sale_price' => DB::raw('origional_price * (1 - discount)')
        ]);
        return Product::all();
    }
    /**
     * Display a listing of the resource.
     */
    // public function search_keyword(String $key_word)
    // {
    //     $products = Product::search($key_word)
    //         ->must(new Matching('name', 'ipsum'))
    //         ->get();
    //     return view('your_view', ['products' => $products]);
    // }

    public function main_product($id)
    {
        $product = Product::query();
        if ($id == 1) {
            return $product->where('sold', '>', 100)->orderBy('sold', 'desc')->limit(6)->get();
        }
        if ($id == 2) {
            return $product->where('discount', '>', '0.49')->orderBy('discount', 'desc')->limit(6)->get();
        }
        return "Not found";
    }

    public function filters(Request $request)
    {
        // if ($request->keyword) {
        //     return $request->keyword;
        // }

        // $product = Product::query();

        // if ($request->keyword != null) {
        //     $keyword = $request->input('keyword');
        //     $products = Product::search($keyword)->paginate();
        //     $product = $products->items();
        // } else {
        //     // Không có keyword, thực hiện truy vấn và lấy mảng dữ liệu
        //     $product = $product->get()->toArray();
        // }

        // // return $product;


        // if ($request->cat_id >= 1 && $request->cat_id <= 7) {
        //     $product = $product->where('cat_id', '=', $request->cat_id);
        // }

        $productQuery = Product::query();

        if ($request->keyword != null) {
            $keyword = $request->input('keyword');
            $products = Product::search($keyword)->paginate();
            $productData = $products->items(); // Lưu trữ dữ liệu tìm kiếm
        } else {
            // Không có keyword, thực hiện truy vấn và lấy mảng dữ liệu
            $productData = $productQuery->get()->toArray();
        }


        $productQuery = Product::query()->tap(function ($query) use ($productData) {
            // Sử dụng dữ liệu từ tìm kiếm để thêm điều kiện vào truy vấn SQL
            $ids = collect($productData)->pluck('id')->toArray();
            $query->whereIn('id', $ids);
        });

        // Thêm điều kiện vào truy vấn sử dụng $productQuery
        if ($request->cat_id >= 1 && $request->cat_id <= 7) {
            $productQuery = $productQuery->where('cat_id', '=', $request->cat_id);
        }

        // Sử dụng $productQuery cho các truy vấn SQL khác nếu cần


        if ($request->all) {
            // hot: sold
            if ($request->all == 1) {
                $productQuery = $productQuery->where('sold', '>', '100');
            }
            // discount --> flash sale 
            if ($request->all == 2) {
                $productQuery = $productQuery->where('discount', '>', '0.49');
            }
        }
        if ($request->sort >= 1 && $request->sort <= 4) {
            switch ($request->sort) {
                case 1:
                    break;
                case 2:
                    $productQuery = $productQuery->orderBy('sale_price', 'asc');
                    break;
                case 3:
                    $productQuery = $productQuery->orderBy('sale_price', 'desc');
                    break;
                case 4:
                    $now = Carbon::now();
                    $twoMonthsAgo = $now->subMonths(2);
                    // $oneMonthAgo = $now->subMonth(1);

                    $productQuery = $productQuery
                        ->where('created_at', '>=', $twoMonthsAgo)
                        ->orderBy('created_at', 'desc');
                    break;
                default:
                    break;
            }
        }
        // if ($request->keyword != null) {
        //     return collect($product->items());
        // }
        // return $product->get();
        return $productQuery->get(); // Trả về dữ liệu tìm kiếm hoặc dữ liệu thực tế

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $fields = $request->validate([
                'name' => 'required|string',
                'brand' => 'required|string',
                'imgurl' => 'image|required',
                'description' => 'required|string',
                'origional_price' => 'required|string',
                'sale_price' => 'required',
                'discount' => 'required',
                'available' => 'required|string',
                'sold' => 'required|string',
                'cat_id' => 'required|string',
                'create_by' => 'required|string',
                'update_by' => 'required|string'
            ]);
        } catch (ValidationException $e) {
            return response()->json(['message' => $e->getMessage(), 'errors' => $e->errors()], 422);
        }
        $imgurl = Cloudinary::upload($request->file('imgurl')->getRealPath())->getSecurePath();
        $product = Product::create([
            'name' => $fields['name'],
            'brand' => $fields['brand'],
            'imgurl' => $imgurl,
            'description' => $fields['description'],
            'origional_price' => $fields['origional_price'],
            'sale_price' => $fields['sale_price'],
            'discount' => $fields['discount'],
            'available' => $fields['available'],
            'sold' => $fields['sold'],
            'cat_id' => $fields['cat_id'],
            'create_by' => $fields['create_by'],
            'update_by' => $fields['update_by']
        ]);
        return response($product, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {

        return Product::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $product = Product::find($id);
        // check if imgurl exists 
        // after delete existed image
        // update new image
        if (!$product) {
            return "Product not found";
        }
        $data = $request->all();
        $imgurl_error = "";
        $imgurl_old = $product->imgurl;
        if ($request->hasFile('imgurl')) {
            $imgurl = Cloudinary::upload($request->file('imgurl')->getRealPath())->getSecurePath();
            $imgurl_error = $imgurl;
            $data['imgurl'] = $imgurl;
        }
        try {
            $product->update($data);
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
            return response()->json(['errors' => $e->getMessage()], 500);
        }
        $response = [
            'product' => $product,
        ];
        return response($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return Product::destroy($id);
    }
}
