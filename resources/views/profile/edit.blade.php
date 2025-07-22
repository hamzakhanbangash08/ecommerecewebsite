@extends(Auth::user()->hasRole('customer') ? 'layouts.master' : 'layouts.admin')

@section('pageTitle')
<nav aria-label="breadcrumb" class="d-flex justify-content-between align-items-center">
    <ol class="breadcrumb flex-grow-1">
        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Update Profile</li>
    </ol>
    <!-- Optional: Right-aligned content (e.g., a button) -->

</nav>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form method="POST" action="{{ route('profile.password') }}">
                @csrf

                <div class="mb-3">
                    <label for="current_password" class="form-label">Current Password</label>
                    <input type="password" class="form-control" name="current_password" required>
                </div>

                <div class="mb-3">
                    <label for="new_password" class="form-label">New Password</label>
                    <input type="password" class="form-control" name="new_password" required>
                </div>

                <div class="mb-3">
                    <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                    <input type="password" class="form-control" name="new_password_confirmation" required>
                </div>

                <button type="submit" class="btn btn-primary">Update Password</button>
            </form>
        </div>
    </div>
</div>
@endsection