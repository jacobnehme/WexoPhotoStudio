@extends('layouts/app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">Product: #{{$product->barcode}}</div>
                    <div class="card-body">
                        <div>
                            <table class="container-fluid">
                                <thead>
                                <tr class="row">
                                    <th class="col-md-3">Barcode</th>
                                    <th class="col-md-3">Title</th>
                                    <th class="col-md-3">Description</th>
                                    <th class="col-md-3">Created</th>
                                </tr>
                                </thead>
                                <tbody>

                                <tr class="row">
                                    <td class="col-md-3">{{$product->barcode}}</td>
                                    <td class="col-md-3">{{$product->title}}</td>
                                    <td class="col-md-3">{{$product->description}}</td>
                                    <td class="col-md-3">
                                        {{date('j F, Y', strtotime($product->created_at))}}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{--<div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Upload Photo</div>

                    <div class="card-body">

                        <form method="POST" action="{{ action('PhotoController@store')}}" enctype="multipart/form-data">
                            @csrf

                            --}}{{--                            {{ Form::hidden('product_id', $product->id) }}--}}{{--
                            <input type="hidden" name="product_id" value={{ $product->id }}>

                            <div class="form-group row">
                                <label for="photo" class="col-md-4 col-form-label text-md-right">Photo</label>

                                <div class="col-md-6">
                                    <input id="photo" type="file"
                                           class="form-control{{ $errors->has('photo') ? ' is-invalid' : '' }}"
                                           name="photo" value="{{ old('photo') }}"
                                           style="padding: 0; height: auto" required>

                                    @if ($errors->has('photo'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('photo') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Upload
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>--}}

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">All Photos</div>

                    <div class="card-body">
                        <div class="row">
                            @foreach($product->photos as $photo)
                                <div class="col-md-3">
                                    <img class="img-fluid" src="{{asset('../storage/app/public/'.$photo->path)}}" alt="">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection
