<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index', 'show']);
        $this->middleware('permission:ADMIN', ['except' => ['index', 'show']]);
    }

    public function index(Request $request)
    {
        $products = Product::paginate($request->get('size', 15))->withQueryString();

        return response()->json($products, Response::HTTP_OK);
    }

    public function store(CreateProductRequest $request)
    {
        $productData = $request->validated();

        $product = Product::create($productData);


        return response()->json($product, Response::HTTP_CREATED);
    }

    public function show(int $id)
    {
        $product = Product::findOrFail($id);

        return response()->json($product, Response::HTTP_OK);
    }

    public function update(UpdateProductRequest $request, int $id)
    {
        $product = Product::find($id);
        $productData = $request->validated();

        $product->update($productData);

        return response()->json($product, Response::HTTP_OK);
    }

    public function destroy(int $id)
    {
        $product = Product::findOrFail($id);

        $product->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
