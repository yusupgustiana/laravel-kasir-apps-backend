<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;


class ProductController extends Controller
{
    public function index()
    {
        $products = \App\Models\Product::orderBy('id','desc')->get();
        return response()->json([
            'success' => true,
            'data' => $products,
            'message' => 'Product retrieved successfully.',
        ], 200);
    }
}
