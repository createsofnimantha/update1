@extends('layouts.app')

@section('header')
<h2 class="mb-4 text-center text-warning fw-bold">✏️ Edit Book</h2>
@endsection

@section('content')
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
      <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-5">
          <form action="{{ route('books.update', $book) }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf
            @method('PUT')

            @if ($errors->any())
              <div class="alert alert-danger">
                <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <!-- Title -->
            <div class="mb-4">
              <label class="form-label fw-semibold fs-5">📖 Title</label>
              <input type="text" name="title" class="form-control form-control-lg @error('title') is-invalid @enderror"
                value="{{ old('title', $book->title) }}" required>
              @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <!-- Author -->
            <div class="mb-4">
              <label class="form-label fw-semibold fs-5">✍️ Author</label>
              <input type="text" name="author" class="form-control form-control-lg @error('author') is-invalid @enderror"
                value="{{ old('author', $book->author) }}" required>
              @error('author') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <!-- Published Year -->
            <div class="mb-4">
              <label class="form-label fw-semibold fs-5">📅 Published Year</label>
              <input type="text" name="published_year" class="form-control form-control-lg @error('published_year') is-invalid @enderror"
                value="{{ old('published_year', $book->published_year) }}">
              @error('published_year') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <!-- Category -->
            <div class="mb-4">
              <label class="form-label fw-semibold fs-5">📂 Category</label>
              <select name="category_id" id="categorySelect" class="form-select form-select-lg @error('category_id') is-invalid @enderror" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                  <option value="{{ $category->id }}" 
                    {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                  </option>
                @endforeach
              </select>
              @error('category_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <!-- Subcategory -->
            <div class="mb-4">
              <label class="form-label fw-semibold fs-5">📑 Subcategory</label>
              <select name="subcategory_id" id="subcategorySelect" class="form-select form-select-lg @error('subcategory_id') is-invalid @enderror" required>
                <option value="">Select Subcategory</option>
              </select>
              @error('subcategory_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <!-- Cover Image -->
            <div class="mb-5">
              <label class="form-label fw-semibold fs-5">🖼️ Cover Image</label>
              <input type="file" name="cover_image" class="form-control form-control-lg @error('cover_image') is-invalid @enderror">
              @error('cover_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
              @if ($book->coverImage)
                <img src="{{ asset('storage/' . $book->coverImage->image_path) }}" class="mt-3 rounded shadow-sm" width="100" alt="Cover">
              @endif
            </div>

            <!-- Buttons -->
            <div class="d-flex justify-content-between">
              <button type="submit" class="btn btn-warning btn-lg rounded-pill px-4 shadow-sm">💾 Update Book</button>
              <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary btn-lg rounded-pill px-4">Cancel</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- JavaScript for Dynamic Subcategory -->
<script>
const categories = @json($categories);
const selectedCategoryId = "{{ old('category_id', $book->category_id) }}";
const selectedSubId = "{{ old('subcategory_id', $book->subcategory_id) }}";

function loadSubcategories(categoryId) {
  const subSelect = document.getElementById('subcategorySelect');
  subSelect.innerHTML = '<option value="">Select Subcategory</option>';
  const selectedCategory = categories.find(cat => cat.id == categoryId);
  if (selectedCategory) {
    selectedCategory.subcategories.forEach(sub => {
      const opt = document.createElement('option');
      opt.value = sub.id;
      opt.textContent = sub.name;
      if (sub.id == selectedSubId) opt.selected = true;
      subSelect.appendChild(opt);
    });
  }
}

document.getElementById('categorySelect').addEventListener('change', function () {
  loadSubcategories(this.value);
});

// Load on page
window.addEventListener('DOMContentLoaded', () => {
  if (selectedCategoryId) {
    document.getElementById('categorySelect').value = selectedCategoryId;
    loadSubcategories(selectedCategoryId);
  }
});
</script>

<style>
input.form-control:hover, input.form-control:focus, select.form-select:focus {
  border-color: #ffc107;
  box-shadow: 0 0 5px rgba(255, 193, 7, 0.3);
}
</style>
@endsection
