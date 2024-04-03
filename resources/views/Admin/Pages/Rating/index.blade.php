@extends('Admin.Pages.test.template')

@section('title', 'Rating Apps')
@section('meta-tag')
    <meta name="description" content="Rating Apps">
@endsection

@section('title', 'Rating Apps')
@section('subtitle', 'Rating Apps')

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Statistik Per Rating</h4>
                <div class="row">
                    @foreach($statistik as $item)
                        <div class="col-md">
                            <div class="card text-center" style="border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                                <div class="card-body">
                                    <h5 class="card-title
                                    @switch($item->rating)
                                        @case(1)
                                        text-danger
                                        @break
                                        @case(2)
                                        text-warning
                                        @break
                                        @case(3)
                                        text-info
                                        @break
                                        @case(4)
                                        text-primary
                                        @break
                                        @case(5)
                                        text-success
                                        @break
                                    @endswitch
                                        ">
                                        <i class="bi bi-star
                                        @switch($item->rating)
                                            @case(1)
                                            text-danger
                                            @break
                                            @case(2)
                                            text-warning
                                            @break
                                            @case(3)
                                            text-info
                                            @break
                                            @case(4)
                                            text-primary
                                            @break
                                            @case(5)
                                            text-success
                                            @break
                                        @endswitch
                                            "></i> {{ $item->rating }}
                                    </h5>
                                    <p class="card-text">{{ $item->total }} Rating</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Rating</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Rating Apps</th>
                            <th>Comment</th>
                            <th>Rating Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><i class="bi bi-star-fill text-warning"></i> {{ $item->rating }}
                                </td>
                                <td>{{ $item->comment }}</td>
                                <td>{{ date('d F Y', strtotime($item->created_at)) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
@endsection
