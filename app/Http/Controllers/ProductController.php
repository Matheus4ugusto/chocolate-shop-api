<?php

namespace App\Http\Controllers;

use App\Helpers\UploadFileFromBase64;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;

class ProductController extends Controller
{

    use UploadFileFromBase64;

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
        unset($productData['image']);
        $product = Product::create($productData);

        if ($request->has('image')) {
            $product->image = $this->productFile($request, $product, 'image');
            $product->save();
        }

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

        if ($request->has('image')) {
            $productData['image'] = $this->productFile($request, $product, 'image');
        }

        $product->update($productData);

        return response()->json($product, Response::HTTP_OK);
    }

    public function destroy(int $id)
    {
        $product = Product::findOrFail($id);

        $this->removeFileIfExists($product, 'image');

        $product->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    private function ProductFile(Request $request, Product $product, string $field)
    {
        $file = $this->uploadFile($request->get($field));
        $extension = Arr::last(explode('/', $file->getMimeType()));
        $fileName = $product->id . "-{$field}" . time() . ".{$extension}";

        $file->storeAs('public/products/' . $product->id, $fileName);
        if ($product->$field) {
            $this->removeFileIfExists($product, $field);
        }
        return $fileName;
    }

    private function removeFileIfExists(Product $product, string $field)
    {
        $executablePath = "{$field}Path";
        if (file_exists($product->$executablePath())) {
            unlink($product->$executablePath());
        }
    }
}
