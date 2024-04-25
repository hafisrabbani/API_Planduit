@extends('Admin.Layouts.main-layout')

@section('meta-tag')
    <meta name="description" content="Dictionary">
@endsection

@section('title', 'Update Dictionary ')
@section('subtitle', 'Update Dictionary ')
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}">
@endpush

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Update Dictionary</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.v1.dictionary.update', $dictionary->id) }}" method="POST"
                      id="dictionary-form">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <x-input-field type="text" name="title" label="Title" value="{{ $dictionary->title }}"/>
                        <div class="form-group mt-3">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description"
                                      rows="10">{{$dictionary->description}}</textarea>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
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
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }
            );
            $('#dictionary-form').submit(function (e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function (response) {
                        Swal.fire({
                            title: 'Success!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'Ok'
                        }).then(function () {
                            window.location.href = "{{ route('admin.v1.dictionary.index') }}";
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
