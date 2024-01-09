<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::all();
        return view('supplier.index', compact('suppliers'));
    }
 
    public function Create()
    {
        return view('supplier.create');
    }
 
    public function Store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|unique:suppliers|regex:/^[a-zA-Z ]+$/',
            'address' => 'required|min:3',
            'mobile' => 'required|min:3|digits:10',
            'details' => 'required|min:3|',
            'previous_balance' => 'min:3',

        ]);

        $supplier = new Supplier();
        $supplier->name = $request->name;
        $supplier->address = $request->address;
        $supplier->mobile = $request->mobile;
        $supplier->details = $request->details;
        $supplier->previous_balance = $request->previous_balance;
        $supplier->save();

        return redirect()->back()->with('message', 'New supplier has been added successfully!');
    }
}
