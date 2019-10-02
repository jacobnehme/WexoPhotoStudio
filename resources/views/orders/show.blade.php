@extends('layouts/app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">Order: #{{$order->id}}</div>

                    <div class="card-body">
                        @if($order->orderLines->count())
                            <table class="container-fluid">
                                <thead>
                                <tr class="row">
                                    <th class="col-md-3">Product</th>
                                    <th class="col-md-6">Photos</th>
                                    <th class="col-md-3">Upload</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->orderLines as $orderLine)
                                    <tr class="row">
                                        <td class="col-md-3">
                                            {{$orderLine->product->barcode}} <br>
                                            {{$orderLine->product->title}} <br>
                                            {{$orderLine->product->description}} <br>
                                        </td>
                                        <td class="col-md-6">
                                            @if($orderLine->photoLines->count())
                                                <div class="row">
                                                    @foreach($orderLine->photoLines as $photoLine)
                                                        <div class="col-md-4">
                                                            <img class="img-fluid"
                                                                 src="{{asset('../storage/app/public/'.$photoLine->photo->path)}}"
                                                                 alt="">
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="row">
                                                    @foreach($orderLine->photoLines as $photoLine)
                                                        <div class="col-md-4">
                                                            <form
                                                                action="{{ action('PhotoLineController@update', $photoLine->id)}}"
                                                                method="POST">
                                                                @method('PATCH')
                                                                @Csrf
                                                                <label for="checkbox" class="btn btn-primary"
                                                                       style="width: 100%;">
                                                                    <input type="checkbox" name="status"
                                                                           onchange="this.form.submit()" {{$photoLine->status ? 'checked' : ''}}>
                                                                </label>
                                                            </form>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </td>
                                        <td class="col-md-3">
                                            <form method="POST" action="{{ action('PhotoController@store')}}"
                                                  enctype="multipart/form-data">
                                                @csrf

                                                <input type="hidden" name="orderLine_id"
                                                       value={{ $orderLine->id }}>
                                                <input type="hidden" name="product_id"
                                                       value={{ $orderLine->product->id }}>

                                                <div class="form-group row">
                                                    <input id="photo" type="file"
                                                           class="form-control{{ $errors->has('photo') ? ' is-invalid' : '' }}"
                                                           name="photo" value="{{ old('photo') }}"
                                                           onchange="this.form.submit()"
                                                           style="padding: 0; height: auto" required>

                                                    @if ($errors->has('photo'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('photo') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection
