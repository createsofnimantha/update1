<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Add New Book</title>

  <!-- Bootstrap 5 CSS CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  
  <style>
    input.form-control:hover,
    input.form-control:focus,
    select.form-select:focus {
      border-color: #0d6efd;
      box-shadow: 0 0 8px rgba(13, 110, 253, 0.3);
    }
  </style>
</head>
<body>

  <div class="container mt-5">
    <h2 class="mb-4 text-center text-primary fw-bold">➕ Add New Book</h2>

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
                  id="title" 
                  name="title" 
                  class="form-control form-control-lg @error('title') is-invalid @enderror" 
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
                  id="author" 
                  name="author" 
                  class="form-control form-control-lg @error('author') is-invalid @enderror" 
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
                  type="number" 
                  id="published_year" 
                  name="published_year" 
                  class="form-control form-control-lg @error('published_year') is-invalid @enderror" 
                  value="{{ old('published_year') }}" 
                  placeholder="e.g. 2023" 
                  min="1000" max="{{ date('Y') }}" 
                  required>
                @error('published_year')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <!-- Category -->
              <div class="mb-4">
                <label for="category_id" class="form-label fw-semibold fs-5">📂 Category</label>
                <select 
                  id="categorySelect" 
                  name="category_id" 
                  class="form-select form-select-lg @error('category_id') is-invalid @enderror" 
                  required>
                  <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>Select Category</option>
                  @foreach ($categories as $category)
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
                  id="subcategorySelect" 
                  name="subcategory_id" 
                  class="form-select form-select-lg @error('subcategory_id') is-invalid @enderror" 
                  required>
                  <option value="" disabled selected>Select Subcategory</option>
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
                  id="cover_image" 
                  name="cover_image" 
                  class="form-control form-control-lg @error('cover_image') is-invalid @enderror" 
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

  <!-- Bootstrap 5 JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Dynamic Subcategory Loader Script -->
  <script>
    const categories = @json($categories);
    const oldSubcategoryId = {{ old('subcategory_id', 'null') }};

    const categorySelect = document.getElementById('categorySelect');
    const subcategorySelect = document.getElementById('subcategorySelect');

    function loadSubcategories(categoryId) {
      subcategorySelect.innerHTML = '<option value="" disabled selected>Select Subcategory</option>';
      if (!categoryId) return;

      const selectedCategory = categories.find(cat => cat.id == categoryId);
      if (!selectedCategory) return;

      selectedCategory.subcategories.forEach(sub => {
        const option = document.createElement('option');
        option.value = sub.id;
        option.textContent = sub.name;
        if (oldSubcategoryId == sub.id) option.selected = true;
        subcategorySelect.appendChild(option);
      });
    }

    categorySelect.addEventListener('change', () => {
      loadSubcategories(categorySelect.value);
    });

    window.addEventListener('DOMContentLoaded', () => {
      if (categorySelect.value) {
        loadSubcategories(categorySelect.value);
      }
    });
  </script>
</body>
</html>
