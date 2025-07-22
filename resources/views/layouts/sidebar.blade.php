@php
$categoryIcons = [
'Electronics' => 'bi-phone',
'Fashion' => 'bi-bag',
'Home and kitchen' => 'bi-house-door',
'beauty and health and kitchen' => 'bi-house-door',
'Books' => 'bi-book',
'toys and games' => 'bi-bicycle',
];
@endphp
<aside class="app-sidebar bg-dark shadow" data-bs-theme="dark" style="min-height: 100vh;">
  <div class="sidebar-brand text-center py-4 border-bottom border-secondary">
    <a href="/index.html" class="brand-link d-flex  align-items-center text-white text-decoration-none">
      <img src="/images/hamzakhalogo.png" alt="Logo" class="brand-image opacity-75 mt-1 mb-0 shadow-sm rounded" style="width: 70px; height: auto;">
      <span class="brand-text fw-bold fs-5">Ecommerce Shop</span>
    </a>
  </div>

  <div class="sidebar-wrapper px-3 mt-3">
    <nav>
      <h6 class="text-uppercase text-muted small fw-bold mb-2">Product Categories</h6>
      <ul class="nav flex-column gap-1">
        <li class="nav-item">
          <a href="{{ route('products.index') }}" class="nav-link text-white d-flex align-items-center gap-2 px-3 py-2 rounded hover-bg">
            <i class="bi bi-box-seam-fill"></i> <!-- Box icon -->
            All Categories
          </a>
        </li>

        @foreach($sidebarCategories as $cat)

        @php
        $iconClass = $categoryIcons[$cat->name] ?? 'bi-tag'; // default icon
        @endphp
        <li class="nav-item">
          <a href="{{ route('categories.products', $cat->id) }}" class="nav-link text-white d-flex align-items-center gap-2 px-3 py-2 rounded hover-bg">
            <i class="bi {{ $iconClass }}"></i> <!-- Tag icon for category -->
            {{ $cat->name }}
          </a>
        </li>
        @endforeach
      </ul>
    </nav>
  </div>
</aside>