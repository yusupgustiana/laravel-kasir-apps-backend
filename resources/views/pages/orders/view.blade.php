@extends('layouts.app')

@section('title', 'order detail')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>DETAIL ORDER</h1>
                {{-- <div class="section-header-button">
                    <a href="{{ route('product.create') }}" class="btn btn-primary">Add New</a>
                </div> --}}
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">order</a></div>
                    <div class="breadcrumb-item">Order Detail</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')


                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">

                                    <div class="card-body">
                                        {{-- <div class="float-right">
                                            <form method="GET" action="{{ route('product.index') }}">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="Search"
                                                        name="name">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary"><i
                                                                class="fas fa-search"></i></button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div> --}}
                                        <div class="clearfix mb-3"></div>
                                        <div class="table-responsive">
                                            <table class="table-striped table">
                                                <tr>
                                                    <th>Nama product</th>
                                                    <th>harga</th>
                                                    <th>total item</th>
                                                    <th>total harga</th>


                                                </tr>
                                                @foreach ($orderItems as $item)
                                                <tr>

                                                    <td>{{ $item->product->name }}</td>
                                                    </td>
                                                    <td>
                                                        {{ $item->product->price }}
                                                    </td>
                                                    <td>
                                                        {{ $item->quantity }}
                                                    </td>
                                                    <td>
                                                        {{ $item->total_price }}

                                                    </td>

                                                </tr>
                                            @endforeach
                                            </table>
                                        </div>
                                        <div class="float-right">

                                            {{-- {{ $orders->withQueryString()->links() }} --}}

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-Users.js') }}"></script>
@endpush
