<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Models\Product;
use Mockery\Exception;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Product::class, 'product');
    }

    public function index()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        if (!$request->hasFile('image')){
            return throw new Exception('Image file not found in request.');
        }

        $fileName = Str::random(3) . time() . '.' . $request->image->extension();
        $request->image->storeAs('public/images', $fileName);

        $product = new Product();
        $product->name = $request->name;
        $product->price = (float)$request->price;
        $product->description = $request->description;
        $product->image = $fileName;
        $product->save();

        return response($product);

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
    public function update(UpdateProductRequest $request, Product $product)
    {
        if ($request->hasFile('image')){
            $fileName = Str::random(3) . time() . '.' . $request->image->extension();
            $request->image->storeAs('public/images', $fileName);
            File::delete('public/images/' . $product->image);
        }

        $product->update($request->validated());

        return response()->json([$product]);
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

        return response()->json(['message' => 'Product deleted succesfully'], 200);
    }
}
