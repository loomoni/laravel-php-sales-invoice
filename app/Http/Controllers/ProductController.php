<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSupplier;
use App\Models\Supplier;
use App\Models\Tax;
use App\Models\Unit;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        // $products = Product::all();
        // $additional = ProductSupplier::all();
        // $additional = ProductSupplier::with('products')->get();

        $products['products'] = Product::getProducts();
        return view('product.index',  $products);
    }
 
    public function Create()
    {
        $suppliers =Supplier::all();
        $categories = Category::all();
        $taxes = Tax::all();
        $units = Unit::all();

        return view('product.create', compact('categories','taxes','units','suppliers'));
    }
 
    public function Store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|unique:products|regex:/^[a-zA-Z ]+$/',
            'serial_number' => 'required',
            'model' => 'required|min:3',
            'category_id' => 'required',
            'sales_price' => 'required',
            'unit_id' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tax_id' => 'required',

        ]);


        $product = new Product();
        $product->name = $request->name;
        $product->serial_number = $request->serial_number;
        $product->model = $request->model;
        $product->category_id = $request->category_id;
        $product->sales_price = $request->sales_price;
        $product->unit_id = $request->unit_id;
        $product->tax_id = $request->tax_id;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();        
            $image->move(public_path('images/product/'), $imageName);
            $product->image = $imageName;
        }



        $product->save();

        foreach($request->supplier_id as $key => $supplier_id){
            $supplier = new ProductSupplier();
            $supplier->product_id = $product->id;
            $supplier->supplier_id = $request->supplier_id[$key];
            $supplier->price = $request->supplier_price[$key];
            $supplier->save();
        }
        return redirect()->back()->with('message', 'New product has been added successfully');
    }
}
