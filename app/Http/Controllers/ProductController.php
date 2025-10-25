<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::paginate(10);
        return view('product.index', [
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
//            'product_id',
//            'product_percent',
//            'start_date',
//            'end_date',
//            'is_active'
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'status' => 'nullable',
        ]);

        Product::create([
            //            'product_id',
//            'product_percent',
//            'start_date',
//            'end_date',
//            'is_active'
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status == true ? 1:0,
        ]);

        return redirect('/product')->with('status','Product Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $category)
    {
        $request->validate([
//            'name',
//            'description',
//            'price',
//            'category',
//            'image',
//            'is_active'
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'status' => 'nullable',
        ]);

        $category->update([
            //            'name',
//            'description',
//            'price',
//            'category',
//            'image',
//            'is_active'
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status == true ? 1:0,
        ]);

        return redirect('/product')->with('status','Product Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect('/product')->with('status','Product Deleted Successfully');
    }
}
