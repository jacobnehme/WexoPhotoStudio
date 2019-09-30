@extends('layouts/app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">All Products (dev)</div>

                    <div class="card-body">

                        <table class="container-fluid">
                            <thead>
                            <tr class="row">
                                <th class="col-md-4">Title</th>
                                <th class="col-md-4">Description</th>
                                <th class="col-md-4">Created</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($products as $product)
                                <tr class="row">
                                    <td class="col-md-4">
                                        {{$product->title}}
                                    </td>
                                    <td class="col-md-4">
                                        {{$product->description}}
                                    </td>
                                    <td class="col-md-4">
                                        {{date('j F, Y', strtotime($product->created_at))}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <a class="btn btn-primary" href="{{ action('ProductController@create')}}">
                    Create
                </a>

            </div>
        </div>
    </div>
@endsection
