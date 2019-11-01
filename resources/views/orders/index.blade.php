@extends('layouts/app')

@section('content')
    <div class="container">
        {{--        <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                Dashboard - Orders
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
                                        <a class="btn btn-primary" href="{{ action('OrderController@create')}}">
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
                    <div class="card-header">My Orders</div>

                    <div class="card-body">

                        <table class="container-fluid">
                            <thead>
                            <tr class="row">
                                <th class="col-md-2">Order ID</th>
                                <th class="col-md-2">Quantity</th>
                                <th class="col-md-2">Status</th>
                                <th class="col-md-3">Created</th>
                                <th class="col-md-3">Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr class="row">
                                    <td class="col-md-2">
                                        #{{$order->id}}
                                    </td>
                                    <td class="col-md-2">
                                        {{$order->orderLines->count()}}
                                    </td>
                                    <td class="col-md-2">
                                        N/A
                                    </td>
                                    <td class="col-md-3">
                                        {{date('j F, Y', strtotime($order->created_at))}}
                                    </td>
                                    <td class="col-md-3">
                                        {{--                                        TODO Add glyphicons--}}
                                        {{--                                        <a href="{{ action('OrderController@show', $order->id)}}">Details</a>--}}
                                        @if(auth()->user()->role_id == \App\Role::admin())
                                            <form action="{{ action('OrderController@update', $order->id)}}"
                                                  method="POST">
                                                @method('PATCH')
                                                @csrf

                                                <select name="photographer_id" required>
                                                    <option disabled hidden selected>Choose...</option>
                                                    {{--                                                        @foreach(\App\User::where('role_id', \App\Role::photographer()) as $user)--}}
                                                    @foreach(\App\Photographer::all() as $photographer)
                                                        <option
                                                            value="{{$photographer->id}}"
                                                            {{$photographer->id == $order->photographer_id ? 'selected' : ''}}
                                                        >{{$photographer->user()->email}}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                {{--                                                    <input name="photographer_id" type="hidden"
                                                                                                           value="{{auth()->user()->photographer()->id}}">--}}
                                                <button type="submit">Select</button>
                                            </form>
                                        @endif
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
