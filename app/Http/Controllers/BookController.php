<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\CoverImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    // Show dashboard with only current user's books
    public function index()
    {
        $books = Book::with(['coverImage', 'category', 'subcategory'])
                    ->where('user_id', Auth::id())  // Only current user's books
                    ->latest()
                    ->get();

        return view('books.index', compact('books'));
    }

    // Show create form with category data
    public function create()
    {
        $categories = Category::with('subcategories')->get();
        return view('books.create', compact('categories'));
    }

    // Store book and image
public function store(Request $request)
{
    $data = $request->validate([
        'title' => 'required|string',
        'author' => 'required|string',
        'published_year' => 'nullable|digits:4',
        'category_id' => 'required|exists:categories,id',
        'subcategory_id' => 'required|exists:subcategories,id',
        'cover_image' => 'nullable|image|max:2048',
    ]);

    $book = Book::create([
        'title' => $data['title'],
        'author' => $data['author'],
        'published_year' => $data['published_year'] ?? null,
        'user_id' => Auth::id(),
        'category_id' => $data['category_id'],
        'subcategory_id' => $data['subcategory_id'],
    ]);

    // Save the cover image if provided
    if ($request->hasFile('cover_image')) {
        $path = $request->file('cover_image')->store('covers', 'public');
        $book->coverImage()->create(['image_path' => $path]);
    }

    return redirect()->route('dashboard')->with('success', 'Book added!');
}

    // Show edit form with category/subcategory
    public function edit(Book $book)
    {
        // Ensure the user is authorized to edit this book
        $this->authorizeBookOwner($book);

        // Load cover image and categories with subcategories
        $book->load('coverImage');
        $categories = Category::with('subcategories')->get();

        return view('books.edit', compact('book', 'categories'));
    }

    // Update book and cover image
    public function update(Request $request, Book $book)
    {
        // Ensure the user is authorized to edit this book
        $this->authorizeBookOwner($book);

        // Validate the incoming data
        $data = $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'published_year' => 'nullable|digits:4',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:subcategories,id',
            'cover_image' => 'nullable|image|max:2048',  // Validate cover image
        ]);

        // Update book information
        $book->update([
            'title' => $data['title'],
            'author' => $data['author'],
            'published_year' => $data['published_year'] ?? null,
            'category_id' => $data['category_id'],
            'subcategory_id' => $data['subcategory_id'],
        ]);

        // Handle cover image update if a new one is uploaded
        if ($request->hasFile('cover_image')) {
            if ($book->coverImage) {
                // Delete old cover image from storage
                Storage::disk('public')->delete($book->coverImage->image_path);
                $book->coverImage()->delete();
            }

            $path = $request->file('cover_image')->store('covers', 'public');
            $book->coverImage()->create(['image_path' => $path]);
        }

        return redirect()->route('dashboard')->with('success', 'Book updated!');
    }

    // Delete book and image
    public function destroy(Book $book)
    {
        // Ensure the user is authorized to delete this book
        $this->authorizeBookOwner($book);

        // If the book has a cover image, delete it from storage
        if ($book->coverImage) {
            Storage::disk('public')->delete($book->coverImage->image_path);
            $book->coverImage()->delete();
        }

        // Delete the book record
        $book->delete();

        return redirect()->route('dashboard')->with('success', 'Book deleted!');
    }

    // Helper to check book ownership
    private function authorizeBookOwner(Book $book)
    {
        if ($book->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
    }
}
