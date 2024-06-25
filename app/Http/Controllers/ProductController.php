<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Storage;


class ProductController extends Controller
{
    // public function index(Request $request)
    // {
    //     $products=DB::table('products')
    //     ->when($request->input('name'), function ($query, $name) {
    //        return  $query->where('name', 'like', '%' . $name . '%');
    //     })
    //     ->orderBy('id','desc')
    //     ->paginate(10);
    //     return view('pages.products.index',compact('products'));
    // }
    // public function create()
    // {

    //     return view('pages.products.create-product');
    // }


    public function index(Request $request)
    {
        // Ambil semua kategori unik dari tabel produk
        $categories = DB::table('products')->select('category')->distinct()->get();

        // Ambil nilai kategori dari parameter query
        $category = $request->input('category');

        // Query untuk produk dengan filter kategori dan pencarian berdasarkan nama
        $products = DB::table('products')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('name', 'like', '%' . $name . '%');
            })
            ->when($category && $category !== 'all', function ($query) use ($category) {
                return $query->where('category', $category);
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('pages.products.index', compact('products', 'categories'));
    }
    public function create()
    {

        return view('pages.products.create-product');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|unique:products',
            'price' => 'required|integer',
            'stock' => 'required |integer',
            'category' => 'required| in:food,drink,snack',
            'image' => 'required| image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        $filename =time().'.'.$request->image->extension();
        $request->image->storeAs('public/products', $filename);
        $data = $request->all();

        $product =new \App\Models\Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->category = $request->category;
        $product->image = $filename;
        $product->save();

        return redirect()->route('product.index') ->with('success','Product created successfully');
    }

//     public function store(Request $request)
// {
//     $request->validate([
//         'name' => 'required|min:3|unique:products',
//         'price' => 'required|integer',
//         'stock' => 'required|integer',
//         'category' => 'required|in:food,drink,snack',
//         'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
//     ]);

//     // Simpan gambar ke dalam direktori yang sesuai
//     $filename = time().'.'.$request->image->extension();
//     $request->image->storeAs('public/products', $filename);

//     // Buat entri baru dalam database
//     $product = new \App\Models\Product();
//     $product->name = $request->name;
//     $product->price = $request->price;
//     $product->stock = $request->stock;
//     $product->category = $request->category;
//     $product->image = $filename;
//     $product->save();

//     // Berikan respons yang sesuai (sesuai dengan kebutuhan API atau aplikasi web Anda)
//     return response()->json(['message' => 'Product created successfully', 'data' => $product], 201);
//     // Atau jika ini adalah bagian dari aplikasi web, gunakan redireksi
//     // return redirect()->route('product.index')->with('success', 'Product created successfully');
// }

    public function edit($id)
    {

        $product = \App\Models\Product::findOrFail($id);
        return view('pages.products.edit',compact('product'));
    }
    public function update(Request $request, $id)
    {

        $data = $request->all();
        $product = \App\Models\Product::findOrFail($id);
        $product->update($data);
        return redirect()->route('product.index') ->with('success','Product updated successfully');
    }
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found.',
            ], 404);
        }

        // Hapus file gambar terkait
        if (Storage::disk('public')->exists('public/products/' . $product->image)) {
            Storage::disk('public')->delete('public/products/' . $product->image);
        }

        // Hapus entri produk dari database
        $product->delete();

        return redirect()->route('product.index') ->with('success','Product deleted successfully');
    }

}

