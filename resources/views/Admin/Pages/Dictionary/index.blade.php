@extends('Admin.Pages.test.template')

@section('title', 'Dashboard')
@section('meta-tag')
    <meta name="description" content="Dashboard">
@endsection

@section('title', 'Dashboard')
@section('subtitle', 'Dashboard')

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Dictionary</h4>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.v1.dictionary.create') }}" class="btn btn-primary"><i
                            class="bi bi-plus"></i> Dictionary</a>
                </div>
                <div class="table-responsive mt-3">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Title</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
@endpush

