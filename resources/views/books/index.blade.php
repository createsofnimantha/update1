<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Book List</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .table thead th {
      background-color: #212529;
      color: white;
    }
    .table tbody tr:hover {
      background-color: #f1f1f1;
    }
    .cover-img {
      width: 60px;
      height: auto;
      border-radius: 4px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    .btn-custom {
      margin-right: 5px;
    }
    .badge-category {
      background-color: #6f42c1;
    }
    .badge-subcategory {
      background-color: #0d6efd;
    }
    .btn-custom:hover, .btn-custom:focus {
      transform: scale(1.05);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .btn-custom:active {
      transform: scale(1);
    }
    .badge {
      font-size: 0.9rem;
    }
  </style>
</head>
<body>
  <div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="text-dark">📚 Book List</h2>
      <div>
        <a href="{{ route('books.create') }}" class="btn btn-primary btn-custom">
          ➕ Add New Book
        </a>
        <a href="{{ route('category.index') }}" class="btn btn-warning btn-custom">
          🗂️ Manage Categories
        </a>
      </div>
    </div>

    @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif

    <div class="table-responsive">
      <table class="table table-bordered table-hover align-middle">
        <thead>
          <tr>
            <th>📖 Title</th>
            <th>✍️ Author</th>
            <th>📅 Year</th>
            <th>📂 Category</th>
            <th>📑 Subcategory</th>
            <th>🖼️ Image</th>
            <th class="text-center">⚙️ Actions</th>
          </tr>
        </thead>
<tbody>
    @forelse ($books as $book)
        <tr>
            <td>{{ $book->title }}</td>
            <td>{{ $book->author }}</td>
            <td>{{ $book->published_year }}</td>

            <!-- Display Category -->
            <td>
                @if ($book->category)
                    <span class="badge text-white badge-category">{{ $book->category->name }}</span>
                @else
                    <span class="text-muted">N/A</span>
                @endif
            </td>

            <!-- Display Subcategory -->
            <td>
                @if ($book->subcategory)
                    <span class="badge text-white badge-subcategory">{{ $book->subcategory->name }}</span>
                @else
                    <span class="text-muted">N/A</span>
                @endif
            </td>

            <!-- Display Cover Image -->
            <td>
                @if ($book->coverImage)
                    <img src="{{ asset('storage/' . $book->coverImage->image_path) }}" class="cover-img" alt="Cover Image for {{ $book->title }}">
                @else
                    <span class="text-muted">N/A</span>
                @endif
            </td>

            <td class="text-center">
                <a href="{{ route('books.edit', $book) }}" class="btn btn-sm btn-warning btn-custom" title="Edit Book">
                    ✏️ Edit
                </a>
                <form action="{{ route('books.destroy', $book) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Are you sure you want to delete this book?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" title="Delete Book">
                        🗑️ Delete
                    </button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="7" class="text-center text-muted py-3">No books available.</td>
        </tr>
    @endforelse
</tbody>
      </table>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
