@extends('layouts/app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card">
                    <div class="card-header">Order: #{{$order->id}}</div>

                    <div class="card-body">

                        @if($order->orderLines->count())
                            <div>
                                <table class="container-fluid">
                                    <thead>
                                    <tr class="row">
                                        <th class="col-md-3">Product</th>
                                        <th class="col-md-9">Photos</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($order->orderLines as $orderLine)
                                        <tr class="row">
                                            <td class="col-md-3">{{$orderLine->product->title}}</td>
                                            <td class="col-md-9">
                                                @if($orderLine->product->photos->count())
                                                    <div class="row">
                                                        @foreach($orderLine->product->photos as $photo)
                                                            <div class="col-md-4">
                                                                <img class="img-fluid"
                                                                     src="{{asset('../storage/app/public/'.$photo->photo)}}"
                                                                     alt="">
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                <div class="row">
                                                    @foreach($orderLine->product->photos as $photo)
                                                        <div class="col-md-4">
                                                            <form
                                                                action="{{ action('PhotoController@update', $photo->id)}}"
                                                                method="POST">
                                                                @method('PATCH')
                                                                @Csrf
                                                                <label for="checkbox" class="btn btn-primary" style="width: 100%;">
                                                                    Approve
                                                                    <input type="checkbox" name="status"
                                                                           onchange="this.form.submit()" {{$photo->status ? 'checked' : ''}}>
                                                                </label>
                                                            </form>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

@endsection
