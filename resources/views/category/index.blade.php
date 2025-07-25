@extends('layouts.app')

@section('header')
<h2 class="mb-5 text-center text-primary fw-bold">📂 Category & Subcategory Management</h2>
@endsection

@section('content')
<div class="container mb-5">

  {{-- 🔙 Back to Book View Button --}}
  <div class="mb-4 text-end">
    <a href="{{ route('books.index') }}" class="btn btn-outline-primary fw-semibold rounded-3">
      📖 Back to Book View
    </a>
  </div>

  {{-- ✅ Success Message --}}
  @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      ✅ {{ session('success') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <!-- ➕ Add Category Section -->
  <div class="card border-0 shadow-lg rounded-4 mb-5">
    <div class="card-header bg-primary text-white rounded-top-4">
      <h5 class="mb-0">➕ Add New Category</h5>
    </div>
    <div class="card-body bg-light">
      <form method="POST" action="{{ route('category.store') }}">
        @csrf
        <div class="input-group input-group-lg">
          <input type="text" name="name" class="form-control rounded-start-3" placeholder="Enter category name..." required>
          <button class="btn btn-success rounded-end-3" type="submit">Add Category</button>
        </div>
      </form>
    </div>
  </div>

  <!-- 📁 Category List -->
  @forelse ($categories as $category)
    <div class="card border-0 shadow-sm rounded-4 mb-4">
      <div class="card-header bg-success text-white d-flex justify-content-between align-items-center rounded-top-4">
        <span class="fs-5 fw-semibold">📁 {{ $category->name }}</span>
        <div class="btn-group" role="group">
          <a href="{{ route('category.edit', $category->id) }}"
             class="btn btn-sm fw-bold text-white"
             style="background-color: #f0ad4e;" title="Edit">
             ✏️ Edit
          </a>
          <form action="{{ route('category.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete this category and its subcategories?')">
            @csrf @method('DELETE')
            <button class="btn btn-sm fw-bold text-white" style="background-color: #d9534f;" title="Delete">
              🗑 Delete
            </button>
          </form>
        </div>
      </div>

      <div class="card-body bg-white">
        <!-- 📑 Subcategories -->
        <h6 class="fw-bold text-secondary mb-3">📑 Subcategories</h6>
        @if($category->subcategories->count())
          <ul class="list-group mb-3">
            @foreach ($category->subcategories as $sub)
              <li class="list-group-item d-flex justify-content-between align-items-center">
                📌 {{ $sub->name }}
                <form action="{{ route('subcategory.destroy', $sub) }}" method="POST" onsubmit="return confirm('Delete this subcategory?')">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger rounded-pill" title="Delete Subcategory">❌</button>
                </form>
              </li>
            @endforeach
          </ul>
        @else
          <p class="text-muted fst-italic">No subcategories available.</p>
        @endif

        <!-- ➕ Add Subcategory -->
        <form method="POST" action="{{ route('subcategory.store', $category->id) }}">
          @csrf
          <div class="input-group input-group-sm">
            <input type="text" name="name" class="form-control rounded-start-3" placeholder="Enter subcategory name..." required>
            <button class="btn btn-outline-secondary rounded-end-3" type="submit">➕ Add</button>
          </div>
        </form>
      </div>
    </div>
  @empty
    <div class="alert alert-info text-center fw-bold">
      ℹ️ No categories found. Add your first category above!
    </div>
  @endforelse
</div>

<!-- ✅ Load Bootstrap 5 CSS (IMPORTANT) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- ✅ Bootstrap 5 JS (for dismissible alerts) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
