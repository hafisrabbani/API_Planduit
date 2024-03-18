@extends('Admin.Layouts.main-layout')

@section('meta-tag')
    <meta name="description" content="Info Product">
@endsection

@section('title', 'Create Blog')
@section('subtitle', 'Create Blog')
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
                <form action="{{ route('admin.v1.blog.store') }}" method="POST" enctype="multipart/form-data"
                      id="blog-form">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <x-input-field type="text" name="title" label="Title"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="blog_category_id" class="form-label">Category</label>
                                <select class="form-select" id="blog_category_id" name="blog_category_id">
                                    <option value="" selected disabled>-- Select Category --</option>
                                    @foreach($blogCategories as $blogCategory)
                                        <option value="{{ $blogCategory->id }}">{{ $blogCategory->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="published">Published</option>
                                <option value="draft">Draft</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <x-input-field name="thumbnail" label="Thumbnail" type="file"/>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="10"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        ClassicEditor
            .create(document.querySelector("#description"), {
                ckfinder: {
                    uploadUrl: "{{ route('admin.v1.ckeditor.upload').'?_token='.csrf_token() }}"
                }
            })
            .catch((error) => {
                console.error(error)
            })
            .then(editor => {
                editor.ui.view.editable.element.style.height = '400px';
            })
        $(document).ready(function () {
            $('#blog-form').submit(function (e) {
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
                            window.location.href = "{{ route('admin.v1.blog.index') }}";
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
