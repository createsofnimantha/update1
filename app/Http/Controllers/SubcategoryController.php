<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
public function store(Request $request, $categoryId)
{
    $request->validate(['name' => 'required']);
    Subcategory::create([
        'name' => $request->name,
        'category_id' => $categoryId
    ]);
    return redirect()->back()->with('success', 'Subcategory added!');
}

public function destroy(Subcategory $subcategory)
{
    $subcategory->delete();
    return redirect()->back()->with('success', 'Subcategory deleted!');
}

}
