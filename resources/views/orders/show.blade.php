@extends('layout')

@section('title', "Details")

@section('content')

    <h1>Order: #{{$order->id}}</h1>

    @if($order->products->count())
        <div>
            <table>
                <thead>
                <tr>
                    <th>Product</th>
                    <th>Photos</th>
                </tr>
                </thead>
                <tbody>
                @foreach($order->products as $product)
                    <tr>
                        <td>{{$product->title}}</td>
                        <td class="flex">
                            @if($product->photos->count())
                                @foreach($product->photos as $photo)
                                    <img src="https://place-hold.it/200x200" alt="">

                                    <form action="{{ action('PhotoController@update', $photo->id)}}" method="POST">
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

@endsection
