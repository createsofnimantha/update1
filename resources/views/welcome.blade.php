<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Book Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-color: #f8f9fa;
    }
    header {
      background-color: #fff;
      border-bottom: 1px solid #dee2e6;
    }
    .icon-book {
      width: 120px;
      height: 120px;
      color: #ffc107; /* Bootstrap warning yellow */
      margin-bottom: 1.5rem;
    }
  </style>
</head>
<body>
  <header class="shadow-sm">
    <div class="container d-flex justify-content-between align-items-center py-3">
      <div class="d-flex align-items-center gap-3">
        {{-- Replace logo.png with icon --}}
        <svg xmlns="http://www.w3.org/2000/svg" class="icon-book rounded-circle bg-warning p-2" fill="currentColor" viewBox="0 0 16 16" role="img" aria-label="Logo" >
          <path d="M1 2.828c.885-.37 2.154-.828 3.5-.828 1.875 0 3.376.676 4.5 1.586v9.172c-1.124-.91-2.625-1.586-4.5-1.586-1.346 0-2.615.457-3.5.828V2.828z"/>
          <path d="M13.5 1h-10a.5.5 0 0 0 0 1h10a.5.5 0 0 0 0-1z"/>
          <path d="M14 3v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V3h12z"/>
        </svg>
        <h1 class="h4 mb-0 text-dark">Book Management System</h1>
      </div>
      <div>
        <a href="{{ route('register') }}" class="btn btn-outline-primary me-2">Register</a>
        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
      </div>
    </div>
  </header>

  <main class="container mt-5">
    <div class="card text-center shadow-sm">
      <div class="card-body">
        <!-- Big Book Icon instead of image -->
        <svg xmlns="http://www.w3.org/2000/svg" class="icon-book mx-auto d-block" fill="currentColor" viewBox="0 0 16 16" role="img" aria-label="Book Icon">
          <path d="M1 2.828c.885-.37 2.154-.828 3.5-.828 1.875 0 3.376.676 4.5 1.586v9.172c-1.124-.91-2.625-1.586-4.5-1.586-1.346 0-2.615.457-3.5.828V2.828z"/>
          <path d="M13.5 1h-10a.5.5 0 0 0 0 1h10a.5.5 0 0 0 0-1z"/>
          <path d="M14 3v10a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V3h12z"/>
        </svg>

        <h2 class="card-title mb-3">Welcome to the Book Management System</h2>
        <p class="card-text text-muted mb-4">
          Easily manage your book collection, categories, and subcategories with our user-friendly interface.
        </p>
      </div>
    </div>
  </main>

  <footer class="text-center text-muted mt-5 mb-3">
    &copy; {{ date('Y') }} Book Management System. All rights reserved.
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
