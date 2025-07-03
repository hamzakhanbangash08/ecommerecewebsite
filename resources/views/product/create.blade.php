@extends('layouts.master') {{-- aapka master layout --}}

@section('title', 'Add Product')

@section('styles')
<style>

</style>
@endsection
@section('pageTitle')
<h5>Add New Product</h5>
@endsection
@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form id="productForm" enctype="multipart/form-data" enctype="multipart/form-data">
                @csrf

                <!-- Product Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name">
                    <small class="text-danger" id="error_name"></small>
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    <small class="text-danger" id="error_description"></small>
                </div>

                <!-- Price -->
                <div class="mb-3">
                    <label for="price" class="form-label">Price (PKR)</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price">
                    <small class="text-danger" id="error_price"></small>
                </div>

                <!-- Image -->
                <div class="mb-3">
                    <label for="image" class="form-label">Product Image</label>
                    <input type="file" class="form-control" id="image" name="image">
                    <small class="text-danger" id="error_image"></small>
                </div>

                <!-- Category -->
                <div class="mb-3">
                    <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                    <select class="form-select" id="category" name="category">
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <small class="text-danger" id="error_category"></small>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-success">Save Product</button>
            </form>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#productForm').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            // Clear previous errors
            $('small.text-danger').text('');

            $.ajax({
                url: "{{ route('products.store') }}",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                        timer: 2500,
                        showConfirmButton: false
                    }); // ya sweetalert if used

                    // Reset the form
                    $('#productForm')[0].reset();
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, val) {
                            $('#error_' + key).text(val[0]);
                        });
                    } else {
                        alert('Something went wrong.');
                    }
                }
            });
        });
    });
</script>
@endsection