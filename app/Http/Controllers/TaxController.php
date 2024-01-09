<?php

namespace App\Http\Controllers;

use App\Models\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TaxController extends Controller
{
   public function index()
   {
    $taxes = Tax::all();
    return view('tax.index', compact('taxes'));
   }

   public function Create()
   {
    return view('tax.create');
   }

   public function Store(Request $request)
   {
    $request->validate([
        'name' => 'required|unique:taxes|numeric',
    ]);

    $tax = new Tax();
    $tax->name = $request->name;
    $tax->slug = Str::slug($request->name);
    $tax->status = 1;
    $tax->save();

    return redirect()->back()->with('message', 'Tax Created Successfully');

   }
}
