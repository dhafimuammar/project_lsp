<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip Surat Karangduren</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f8f9fa; }
        .sidebar { min-height: 100vh; background: #e9ecef; }
        .sidebar .nav-link.active { font-weight: bold; color: #0d6efd; }
        .sidebar .nav-link { color: #333; }
        .sidebar .nav-link:hover { color: #0d6efd; }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-2 sidebar py-4">
                <h5 class="mb-4">Menu</h5>
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link {{ request()->is('letters*') ? 'active' : '' }}" href="{{ route('letters.index') }}">Arsip</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('categories*') ? 'active' : '' }}" href="/categories">Kategori Surat</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->is('about') ? 'active' : '' }}" href="/about">About</a></li>
                </ul>
            </nav>
            <main class="col-md-10 px-4 py-4">
                @yield('content')
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
