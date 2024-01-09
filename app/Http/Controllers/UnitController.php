<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::all();
        return view('unit.index', compact('units'));
    }
 
    public function Create()
    {
        return view('unit.create');
    }
 
        
    public function Store(Request $request)
    {
    $request->validate([
            'name' => 'required|min:2|unique:units|regex:/^[a-zA-Z ]+$/',
        ]);

        $unit = new Unit();
        $unit->name = $request->name;
        $unit->slug =  Str::slug($request->name);
        $unit->status = 1;
        $unit->save();

        return redirect()->back()->with('message', 'Unit Created Successfully');
 
    }
}
