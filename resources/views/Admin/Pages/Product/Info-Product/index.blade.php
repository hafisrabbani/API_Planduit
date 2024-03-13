@extends('Admin.Layouts.main-layout')

@section('meta-tag')
    <meta name="description" content="Info Product">
@endsection

@section('title', 'Info Product')
@section('subtitle', 'Manage Info Product')

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Info Product</h4>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.v1.info-product.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Info Product</a>
                </div>
                <div class="table-responsive mt-3">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Product</th>
                            <th>Product Key</th>
                            <th>Last Update</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($infoProducts as $infoProduct)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $infoProduct->product_name }}</td>
                                <td>{{ $infoProduct->product_key }}</td>
                                <td>{{ $infoProduct->updated_at }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.v1.info-product.edit', $infoProduct->id) }}"
                                           class="btn btn-warning text-white btn-sm"><i class="bi bi-pencil-fill"></i></a>
                                        <button class="btn btn-danger btn-sm" onclick="deleteData({{ $infoProduct->id }})"><i
                                                class="bi bi-trash-fill"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>>
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script>
        function deleteData(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('admin.v1.info-product.destroy', ':id') }}".replace(':id', id),
                        type: 'DELETE',
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function (response) {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            ).then((result) => {
                                location.reload();
                            });
                        },
                        error: function (response) {
                            Swal.fire(
                                'Error!',
                                response.responseJSON.message,
                                'error'
                            );
                        }
                    });
                }
            });
        }
    </script>
@endpush
