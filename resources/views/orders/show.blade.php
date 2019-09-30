@extends('layouts/app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>Order: #{{$order->id}}</h1>

                @if($order->orderLines->count())
                    <div>
                        <table>
                            <thead>
                            <tr>
                                <th>Product</th>
                                <th>Photos</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order->orderLines as $orderLine)
                                <tr>
                                    <td>{{$orderLine->product->title}}</td>
                                    <td>
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

@endsection
