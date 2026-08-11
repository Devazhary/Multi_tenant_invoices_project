<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('section')->get();
        $sections = Section::all();
        return view('products.products', compact('products', 'sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $validated = $request->validated();
        $product = Product::create($validated);
        if ($product) {
            return redirect()->route('products.index')->with('success', 'تم إضافة المنتج بنجاح');
        }
        return redirect()->route('products.index')->with('error', 'فشل في إضافة المنتج');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $validated = $request->validated();
        $updatedProduct = $product->update($validated);
        if ($updatedProduct) {
            return redirect()->route('products.index')->with('success', 'تم تعديل المنتج بنجاح');
        }
        return redirect()->route('products.index')->with('error', 'فشل في تعديل المنتج');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $deleted = $product->delete();
        if ($deleted) {
            return redirect()->route('products.index')->with('success', 'تم حذف المنتج بنجاح');
        }
        return redirect()->route('products.index')->with('error', 'فشل في حذف المنتج');
    }
}
