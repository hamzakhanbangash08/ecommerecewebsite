<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
  <div class="sidebar-brand text-center py-3">
    <a href="/index.html" class="brand-link d-flex align-items-center justify-content-center">
      <img src="/images/logo.png" alt="Logo" class="brand-image opacity-75 shadow me-2" width="40">
      <span class="brand-text fw-bold text-dark">EdenShop</span>
    </a>
  </div>

  <div class="sidebar-wrapper px-2">
    <nav class="mt-2">
      <h6 class="text-muted ps-2 mt-3">Product Categories</h6>
      <ul class="nav flex-column">
        @foreach($sidebarCategories as $cat)
                <li class="nav-item">
                    <a href="{{ route('categories.products', $cat->id) }}" class="nav-link d-flex align-items-center gap-4">
                        {{ $cat->name }}
                    </a>
                </li>
            @endforeach
      </ul>
    </nav>
  </div>
</aside>