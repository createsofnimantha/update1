@extends('layouts.app')

@section('header')
<h2 class="mb-4 text-center text-primary fw-bold">✏️ Edit Category</h2>
@endsection

@section('content')
<div class="container">

    {{-- 🔙 Back to Category List --}}
    <div class="mb-4 text-end">
        <a href="{{ route('category.index') }}" class="btn btn-outline-secondary fw-semibold rounded-3">
            📂 Back to Categories
        </a>
    </div>

    {{-- ✅ Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            ✅ {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- 📝 Edit Form --}}
    <div class="card border-0 shadow-lg rounded-4">
        <div class="card-header bg-warning text-white rounded-top-4">
            <h5 class="mb-0">📝 Update Category</h5>
        </div>
        <div class="card-body bg-light">
            <form method="POST" action="{{ route('category.update', $category->id) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label fw-bold">Category Name</label>
                    <input type="text" name="name" value="{{ old('name', $category->name) }}" class="form-control form-control-lg rounded-3" required>
                </div>
                <button class="btn btn-warning text-white fw-bold rounded-3" type="submit">
                    💾 Update Category
                </button>
            </form>
        </div>
    </div>
</div>

<!-- ✅ Ensure Bootstrap 5 CSS is loaded -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- ✅ Bootstrap 5 JS (for dismissible alerts) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
