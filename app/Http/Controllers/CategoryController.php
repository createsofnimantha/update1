<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;

class CategoryController extends Controller
{
    // 📂 Show all categories with subcategories
    public function index()
    {
        $categories = Category::with('subcategories')->get();
        return view('category.index', compact('categories'));
    }

    // ➕ Store new category
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories,name'
        ]);

        Category::create($request->only('name'));

        return redirect()->back()->with('success', 'Category added!');
    }

    // 🗑 Delete a category
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted!');
    }

    // ✏️ Show the form to edit a category
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('category.edit', compact('category'));
    }

    // 🔄 Update the category
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:categories,name,' . $id
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name
        ]);

        return redirect()->route('category.index')->with('success', 'Category updated!');
    }
}
