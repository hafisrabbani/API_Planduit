@extends('Admin.Layouts.main-layout')

@section('meta-tag')
    <meta name="description" content="Info Product">
@endsection

@section('title', 'Create Blog Category')
@section('subtitle', 'Create Blog Category')
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}">
@endpush

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Create Info Product</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.v1.blog-category.store') }}" method="POST" enctype="multipart/form-data"
                      id="blog-category-form">
                    @csrf
                    <div class="mb-3">
                        <x-input-field type="text" name="title" label="Title"/>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#blog-category-form').submit(function (e) {
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
                            window.location.href = "{{ route('admin.v1.blog-category.index') }}";
                        });
                    },
                    error: function (response) {
                        let errMsg = response.responseJSON.message
                        Swal.fire({
                            title: 'Something Wrong!',
                            text: errMsg,
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    }
                });
            });
        });
    </script>
@endpush
