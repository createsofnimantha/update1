@extends('layouts.app')

@section('header')
<h2 class="mb-4 text-center text-primary fw-bold">➕ Add New Book</h2>
@endsection

@section('content')
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
      <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-5">
          <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf

            <!-- Title -->
            <div class="mb-4">
              <label for="title" class="form-label fw-semibold fs-5">📖 Title</label>
              <input 
                type="text" 
                class="form-control form-control-lg @error('title') is-invalid @enderror" 
                id="title" name="title" 
                value="{{ old('title') }}" 
                placeholder="Enter book title" 
                required>
              @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Author -->
            <div class="mb-4">
              <label for="author" class="form-label fw-semibold fs-5">✍️ Author</label>
              <input 
                type="text" 
                class="form-control form-control-lg @error('author') is-invalid @enderror" 
                id="author" name="author" 
                value="{{ old('author') }}" 
                placeholder="Enter author name" 
                required>
              @error('author')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Published Year -->
            <div class="mb-4">
              <label for="published_year" class="form-label fw-semibold fs-5">📅 Published Year</label>
              <input 
                type="text" 
                class="form-control form-control-lg @error('published_year') is-invalid @enderror" 
                id="published_year" name="published_year" 
                value="{{ old('published_year') }}" 
                placeholder="e.g. 2023">
              @error('published_year')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Category -->
            <div class="mb-4">
              <label for="category_id" class="form-label fw-semibold fs-5">📂 Category</label>
              <select 
                name="category_id" id="categorySelect" 
                class="form-select form-select-lg @error('category_id') is-invalid @enderror" 
                required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                  <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                  </option>
                @endforeach
              </select>
              @error('category_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Subcategory -->
            <div class="mb-4">
              <label for="subcategory_id" class="form-label fw-semibold fs-5">📑 Subcategory</label>
              <select 
                name="subcategory_id" id="subcategorySelect" 
                class="form-select form-select-lg @error('subcategory_id') is-invalid @enderror" 
                required>
                <option value="">Select Subcategory</option>
              </select>
              @error('subcategory_id')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Cover Image -->
            <div class="mb-5">
              <label for="cover_image" class="form-label fw-semibold fs-5">🖼️ Cover Image</label>
              <input 
                type="file" 
                class="form-control form-control-lg @error('cover_image') is-invalid @enderror" 
                id="cover_image" name="cover_image" 
                accept="image/*">
              @error('cover_image')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill shadow-sm">
              💾 Save Book
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- JavaScript: Dynamic Subcategory Loader -->
<script>
const categories = @json($categories);
const oldSubcategoryId = {{ old('subcategory_id', 'null') }};

document.getElementById('categorySelect').addEventListener('change', function () {
  const subSelect = document.getElementById('subcategorySelect');
  const selectedId = this.value;
  subSelect.innerHTML = '<option value="">Select Subcategory</option>';

  const selectedCategory = categories.find(cat => cat.id == selectedId);
  if (selectedCategory) {
    selectedCategory.subcategories.forEach(sub => {
      const opt = document.createElement('option');
      opt.value = sub.id;
      opt.textContent = sub.name;
      if (oldSubcategoryId === sub.id) {
        opt.selected = true;
      }
      subSelect.appendChild(opt);
    });
  }
});

window.addEventListener('DOMContentLoaded', () => {
  const selectedCategory = document.getElementById('categorySelect').value;
  if (selectedCategory) {
    document.getElementById('categorySelect').dispatchEvent(new Event('change'));
  }
});
</script>

<style>
  input.form-control:hover,
  input.form-control:focus,
  select.form-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 5px rgba(13, 110, 253, 0.3);
  }
</style>
@endsection
