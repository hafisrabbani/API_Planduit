@extends('Admin.Layouts.main-layout')

@section('meta-tag')
    <meta name="description" content="Info Product">
@endsection

@section('title', 'Create Info Product')
@section('subtitle', 'Create Info Product')

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Create Info Product</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.v1.info-product.store') }}" method="POST" enctype="multipart/form-data" id="info-product-form">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <x-input-field type="text" name="product_key" label="Product Key" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <x-input-field type="text" name="product_name" label="Product Name" />
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <x-input-field type="file" name="product_image" label="Product Image" />
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="product_description" id="description" class="form-control" rows="5"
                                  placeholder="Description"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>>
    <script>
        $(document).ready(function () {
            $('#info-product-form').submit(function (e) {
                e.preventDefault();
                let form = $(this);
                let url = form.attr('action');
                let data = new FormData(form[0]);
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        }).then(function () {
                            window.location.href = "{{ route('admin.v1.info-product.index') }}";
                        });
                    },
                    error: function (response) {
                        Swal.fire({
                            title: 'Error!',
                            text: response.responseJSON.message,
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    }
                });
            });
        });
    </script>
@endpush
