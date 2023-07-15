<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Mockery\Exception;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Product::class, 'product');
    }

    public function index()
    {
        return ProductResource::collection(Product::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        if (!$request->hasFile('image')){
            throw new Exception('Image file not found in request.');
        }

        $fileName = Str::random(3) . time() . '.' . $request->image->extension();
        $request->image->storeAs('public/images', $fileName);

        $product = new Product();
        $product->name = $request->name;
        $product->price = (float)$request->price;
        $product->description = $request->description;
        $product->image = $fileName;
        $product->in_stock = $request->in_stock;
        $product->save();

        return response(new ProductResource($product), 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        if ($request->hasFile('image')){
            $fileName = Str::random(3) . time() . '.' . $request->image->extension();
            $request->image->storeAs('public/images', $fileName);
            File::delete('public/images/' . $product->image);
            
            $content = $request->validated();
            $content['image'] = $fileName;

            $product->update($content);
            
            return response(new ProductResource($product));
        }

        $product->update($request->validated());

        return response(new ProductResource($product), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            file_exists('public/images/'.$product->image);
            File::delete('public/images/'.$product->image);
        }catch (Exception $e){
            echo 'Product image not found. ' . $e->getMessage(), "\n";
        }

        $product->delete();

        return response(['message' => 'Product deleted succesfully'], 200);
    }
}
