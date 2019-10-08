@extends('layouts/app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">Order: #{{$order->id}}</div>

                </div>

                    <div class="card-body">
                        @if($order->orderLines->count())
                            <table class="container-fluid">
                                <thead>
                                <tr class="row">
                                    <th class="col-md-2">Product</th>
                                    <th class="col-md-8">Photos</th>
                                    <th class="col-md-2">Upload
                                        <i class="text-danger">(dev)</i>
                                    </th>
                                </tr>
                                {{--{{}}--}}
                                {{-- *!* Refactor TODO Make relations between view and photoline go through order variable --}}

                                <div class="pb-3 border-bottom">Total Approved: #{{ $photoLine->getApproved_Count()}}</div>
                                <div class="pb-3 border-bottom">Total Rejected: #{{ $photoLine->getRejected_Count()}}</div>
                                </thead>
                                <tbody>
                                @foreach($order->orderLines as $orderLine)
                                    <tr class="row">
                                        <td class="col-md-2">
                                            <strong>Barcode: </strong>#{{$orderLine->product->barcode}} <br>
                                            <strong>Title: </strong>{{$orderLine->product->title}} <br>
                                            <strong>Description: </strong>{{$orderLine->product->description}} <br>
                                        </td>
                                        <td class="col-md-8">
                                            @if($orderLine->photoLines->count())
                                                <div class="row">
                                                    @foreach($orderLine->photoLines as $photoLine)

                                                        <div class="col-md-3">
                                                            <div class="image_wrapper">
                                                                <img class="image"
                                                                     src="{{ asset(Storage::url($photoLine->photo->path)) }}"
                                                                     alt="">
                                                                {{-- !!!!!!!! Make some sort of approve and reject icon --- > REMOVE FA CLASSES !!!!!!!!! --}}
                                                                <div class="{{ $photoLine->status ? 'approved_overlay ' : 'rejected_overlay' }}">
                                                                </div>
                                                            </div>
                                                            <form class="pt-2"
                                                                  action="{{ action('PhotoLineController@update', $photoLine->id)}}"
                                                                  method="POST">
                                                                @method('PATCH')
                                                                @Csrf
                                                                <label for="status-{{$photoLine->id}}"
                                                                       class="btn btn-{{$photoLine->status ? 'danger' : 'success'}}">
                                                                    {{$photoLine->status ? 'Reject' : 'Approve'}}
                                                                    <input type="checkbox" name="status"
                                                                           id="status-{{$photoLine->id}}"
                                                                           onchange="this.form.submit()"
                                                                           {{$photoLine->status ? 'checked' : ''}}
                                                                           style="display: none">
                                                                </label>

                                                            </form>
                                                        </div>

                                                    @endforeach

                                                </div>
                                            @endif
                                        </td>


                                        {{--                                        TODO only show for admin--}}
                                        <td class="col-md-2">
                                            <form method="POST" action="{{ action('PhotoController@store')}}"
                                                  enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="orderLine_id"
                                                       value={{ $orderLine->id }}>
                                                <input type="hidden" name="product_id"
                                                       value={{ $orderLine->product->id }}>

                                                <div class="form-group row">
                                                    <label for="photo-{{$orderLine->id}}" class="btn btn-primary">
                                                        Upload to {{$orderLine->product->title}}
                                                    </label>
                                                    <input type="file"
                                                           id="photo-{{$orderLine->id}}"
                                                           class="form-control{{ $errors->has('photo') ? ' is-invalid' : '' }}"
                                                           name="photo" value="{{ old('photo') }}"
                                                           onchange="this.form.submit()" placeholder="" required
                                                           style="display:none;">

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
