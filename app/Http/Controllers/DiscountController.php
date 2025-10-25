<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $discounts = Discount::paginate(10);
        return view('discount.index', [
            'discounts' => $discounts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('discount.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
//            'product_id',
//            'discount_percent',
//            'start_date',
//            'end_date',
//            'is_active'
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'status' => 'nullable',
        ]);

        Discount::create([
            //            'product_id',
//            'discount_percent',
//            'start_date',
//            'end_date',
//            'is_active'
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status == true ? 1:0,
        ]);

        return redirect('/discount')->with('status','Discount Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('discount.show', compact('discount'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('discount.edit', compact('discount'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Discount $category)
    {
        $request->validate([
            //            'product_id',
//            'discount_percent',
//            'start_date',
//            'end_date',
//            'is_active'
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'status' => 'nullable',
        ]);

        $category->update([
            //            'product_id',
//            'discount_percent',
//            'start_date',
//            'end_date',
//            'is_active'
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status == true ? 1:0,
        ]);

        return redirect('/discount')->with('status','Discount Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();
        return redirect('/discount')->with('status','Discount Deleted Successfully');
    }
}
