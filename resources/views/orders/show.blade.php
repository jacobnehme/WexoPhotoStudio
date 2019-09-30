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
                                        <th class="col-md-4">Product</th>
                                        <th class="col-md-4">Photos</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($order->orderLines as $orderLine)
                                        <tr class="row">
                                            <td class="col-md-4">{{$orderLine->product->title}}</td>
                                            <td class="col-md-4">
                                                @if($orderLine->product->photos->count())
                                                    @foreach($orderLine->product->photos as $photo)
                                                        <img src="https://place-hold.it/200x200" alt="">

                                                        <form action="{{ action('PhotoController@update', $photo->id)}}"
                                                              method="POST">
                                                            @method('PATCH')
                                                            @Csrf
                                                            <label for="checkbox">
                                                                <input type="checkbox" name="status"
                                                                       onchange="this.form.submit()" {{$photo->status ? 'checked' : ''}}>
                                                            </label>
                                                        </form>
                                                    @endforeach
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
