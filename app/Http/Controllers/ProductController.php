<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;


class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products=DB::table('products')
        ->when($request->input('name'), function ($query, $name) {
           return  $query->where('name', 'like', '%' . $name . '%');
        })
        ->orderBy('id','desc')
        ->paginate(10);
        return view('pages.products.index',compact('products'));
    }
    public function create()
    {

        return view('pages.products.create-product');
    }
    public function store(Request $request)
    {

        $data = $request->all();
        $products = \App\Models\Product::create($request->all());
        return redirect()->route('product.index') ->with('success','Product created successfully');
    }
    public function edit($id)
    {

        $product = \App\Models\Product::findOrFail($id);
        return view('pages.products.index',compact('product'));
    }
    public function update(Request $request, $id)
    {

        $data = $request->all();
        $product = \App\Models\Product::findOrFail($id);
        $product->update($request->all());
        return redirect()->route('product.index') ->with('success','Product updated successfully');
    }
    public function destroy($id)
    {

        $product = \App\Models\Product::findOrFail($id);
        $product->delete();
        return redirect()->route('product.index') ->with('success','Product deleted successfully');
    }
}
