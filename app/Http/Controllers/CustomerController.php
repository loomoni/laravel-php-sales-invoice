<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('customer.index', compact('customers'));
    }
 
    public function Create()
    {
        return view('customer.create');
    }
 
    public function Store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|unique:customers|regex:/^[a-zA-Z ]+$/',
            'address' => 'required|min:3',
            'mobile' => 'required|min:3|digits:10',
            'email' => 'required|email|unique:customers',
            'details' => 'required|min:3|',
            'previous_balance' => 'min:3',

        ]);

        $customer = new Customer();
        $customer->name = $request->name;
        $customer->address = $request->address;
        $customer->mobile = $request->mobile;
        $customer->email = $request->email;
        $customer->details = $request->details;
        $customer->previous_balance = $request->previous_balance;
        $customer->save();

        return redirect()->back()->with('message', 'Customer added successfully');
    }
}
