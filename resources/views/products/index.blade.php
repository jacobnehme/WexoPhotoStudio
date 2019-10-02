@extends('layouts/app')

@section('content')
    <div class="container">
        {{--<div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Dashboard - Products
                    </div>
                    <div class="card-body">
                        <div class="row">
                            --}}{{--                            TODO Add Search --}}{{--
                            --}}{{--                            <div class="col-md-8">--}}{{--
                            --}}{{--                                <form method="get" action="">--}}{{--

                            --}}{{--                                    <div class="form-group row">--}}{{--
                            --}}{{--                                        <div class="col-md-6">--}}{{--
                            --}}{{--                                            <input id="search" type="number"--}}{{--
                            --}}{{--                                                   name="search" value="{{ old('search') }}" placeholder="Search by id" required autofocus>--}}{{--
                            --}}{{--                                        </div>--}}{{--
                            --}}{{--                                        <div class="col-md-6">--}}{{--
                            --}}{{--                                            <button type="submit" class="btn btn-primary">--}}{{--
                            --}}{{--                                                Search--}}{{--
                            --}}{{--                                            </button>--}}{{--
                            --}}{{--                                        </div>--}}{{--
                            --}}{{--                                    </div>--}}{{--
                            --}}{{--                                </form>--}}{{--
                            --}}{{--                            </div>--}}{{--
                            <div class="col-md-12">
                                <a class="btn btn-primary" href="{{ action('ProductController@create')}}">
                                    Create
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>--}}
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">All Products (dev)</div>

                    <div class="card-body">

                        <table class="container-fluid">
                            <thead>
                            <tr class="row">
                                <th class="col-md-4">Barcode</th>
                                <th class="col-md-4">Title</th>
                                <th class="col-md-4">Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $product)
                                <tr class="row">
                                    <td class="col-md-4">
                                        {{$product->barcode}}
                                    </td>
                                    <td class="col-md-4">
                                        {{$product->title}}
                                    </td>
                                    <td class="col-md-4">
                                        <a href="{{ action('ProductController@show', $product->id)}}">Details</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
