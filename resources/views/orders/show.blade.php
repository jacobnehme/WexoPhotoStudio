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
                                    <th class="col-md-2">Product</th>
                                    <th class="col-md-8">Photos</th>
                                    <th class="col-md-2">Upload
                                        <i class="text-danger">(dev)</i>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->orderLines as $orderLine)

                                    <!-- Modal -->
                                    <div class="modal fade" id="modal-{{$orderLine->id}}" tabindex="-1"
                                         role="dialog" aria-labelledby="exampleModalCenterTitle"
                                         aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered"
                                             role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"
                                                        id="exampleModalLongTitle">{{$orderLine->product->title}}</h5>
                                                    <button type="button" class="close"
                                                            data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div id="carouselExampleIndicators" class="carousel slide"
                                                         data-ride="carousel" data-interval="false"
                                                         data-keyboard="false">
                                                        <ol class="carousel-indicators">
                                                            @foreach($orderLine->product->photos as $photo)
                                                                @if(!$orderLine->photoLines->contains('photo_id', $photo->id))
                                                                    <li data-target="#carouselExampleIndicators"
                                                                        data-slide-to="0"
                                                                        class="{{$loop->first ? 'active' : ''}}"></li>
                                                                @endif
                                                            @endforeach
                                                            @foreach($orderLine->photoLines as $photoLine)
                                                                <li data-target="#carouselExampleIndicators"
                                                                    data-slide-to="0"
                                                                    class="{{$loop->first ? 'active' : ''}}"></li>
                                                            @endforeach
                                                        </ol>
                                                        <div class="carousel-inner">
                                                            @foreach($orderLine->product->photos as $photo)
                                                                @if(!$orderLine->photoLines->contains('photo_id', $photo->id))
                                                                    <div
                                                                        class="carousel-item {{$loop->first ? 'active' : ''}}">
                                                                        @component('components/photo')
                                                                            @slot('orderLineId')
                                                                                {{null}}
                                                                            @endslot
                                                                            @slot('class')
                                                                                {{'primary'}}
                                                                            @endslot
                                                                            @slot('labelText')
                                                                                {{'Pre-shot...'}}
                                                                            @endslot
                                                                            @slot('path')
                                                                                {{$photo->path}}
                                                                            @endslot
                                                                        @endcomponent
                                                                        {{--@component('components.addForm')
                                                                            @slot('orderLineId')
                                                                                {{$orderLine->id}}
                                                                            @endslot
                                                                            @slot('photoId')
                                                                                {{$photo->id}}
                                                                            @endslot
                                                                        @endcomponent--}}
                                                                    </div>
                                                                @endif
                                                            @endforeach

                                                            @foreach($orderLine->photoLines as $photoLine)
                                                                <div
                                                                    class="carousel-item {{$loop->first ? 'active' : ''}}">
                                                                    @component('components/photo')
                                                                        @slot('orderLineId')
                                                                            {{$orderLine->id}}
                                                                        @endslot
                                                                        @slot('class')
                                                                            @if($photoLine->is_approved === null){{'warning'}}
                                                                            @else{{$photoLine->is_approved ? 'success' : 'danger'}}@endif
                                                                        @endslot
                                                                        @slot('labelText')
                                                                            @if($photoLine->is_approved === null)
                                                                                Pending...
                                                                            @else
                                                                                {{$photoLine->is_approved ? 'Approved...' : 'Rejected...'}}
                                                                            @endif
                                                                        @endslot
                                                                        @slot('path')
                                                                            {{$photoLine->photo->path}}
                                                                        @endslot
                                                                    @endcomponent
                                                                    {{--@component('components.statusForm')
                                                                        @slot('action')
                                                                            {{'PhotoLineController@update'}}
                                                                        @endslot
                                                                        @slot('photoLineId')
                                                                            {{$photoLine->id}}
                                                                        @endslot
                                                                        @slot('class')
                                                                            {{$photoLine->is_approved ? 'danger' : 'success'}}
                                                                        @endslot
                                                                        @slot('buttonText')
                                                                            {{$photoLine->is_approved ? 'Reject' : 'Approve'}}
                                                                        @endslot
                                                                        @slot('isChecked')
                                                                            {{$photoLine->is_approved ? 'checked' : ''}}
                                                                        @endslot
                                                                        @slot('path')
                                                                            {{$photoLine->photo->path}}
                                                                        @endslot
                                                                    @endcomponent--}}
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <a class="carousel-control-prev"
                                                           href="#carouselExampleIndicators" role="button"
                                                           data-slide="prev">
                                                            <span class="carousel-control-prev-icon"
                                                                  aria-hidden="true"></span>
                                                            <span class="sr-only">Previous</span>
                                                        </a>
                                                        <a class="carousel-control-next"
                                                           href="#carouselExampleIndicators" role="button"
                                                           data-slide="next">
                                                            <span class="carousel-control-next-icon"
                                                                  aria-hidden="true"></span>
                                                            <span class="sr-only">Next</span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <tr class="row">
                                        <td class="col-md-2">
                                            <strong>Barcode: </strong>#{{$orderLine->product->barcode}} <br>
                                            <strong>Title: </strong>{{$orderLine->product->title}} <br>
                                            <strong>Description: </strong>{{$orderLine->product->description}} <br>
                                            <strong>Approved: </strong>{{$orderLine->approvedCount()}}
                                            / {{$orderLine->photoLines->count()}} <br>
                                        </td>
                                        <td class="col-md-8">
                                            <div class="row">
                                                @foreach($orderLine->product->photos as $photo)
                                                    @if(!$orderLine->photoLines->contains('photo_id', $photo->id))

                                                        <div class="col-md-3">
                                                            @component('components/photo')
                                                                @slot('orderLineId')
                                                                    {{$orderLine->id}}
                                                                @endslot
                                                                @slot('class')
                                                                    {{'primary'}}
                                                                @endslot
                                                                @slot('labelText')
                                                                    {{'Pre-shot...'}}
                                                                @endslot
                                                                @slot('path')
                                                                    {{$photo->path}}
                                                                @endslot
                                                            @endcomponent
                                                            @component('components.addForm')
                                                                @slot('orderLineId')
                                                                    {{$orderLine->id}}
                                                                @endslot
                                                                @slot('photoId')
                                                                    {{$photo->id}}
                                                                @endslot
                                                            @endcomponent
                                                        </div>
                                                    @endif
                                                @endforeach

                                                @foreach($orderLine->photoLines as $photoLine)

                                                    <div class="col-md-3">
                                                        @component('components/photo')
                                                            @slot('orderLineId')
                                                                {{$orderLine->id}}
                                                            @endslot
                                                            @slot('class')
                                                                @if($photoLine->is_approved === null){{'warning'}}
                                                                @else{{$photoLine->is_approved ? 'success' : 'danger'}}@endif
                                                            @endslot
                                                            @slot('labelText')
                                                                @if($photoLine->is_approved === null)
                                                                    Pending...
                                                                @else
                                                                    {{$photoLine->is_approved ? 'Approved...' : 'Rejected...'}}
                                                                @endif
                                                            @endslot
                                                            @slot('path')
                                                                {{$photoLine->photo->path}}
                                                            @endslot
                                                        @endcomponent
                                                        @component('components.statusForm')
                                                            @slot('action')
                                                                {{'PhotoLineController@update'}}
                                                            @endslot
                                                            @slot('photoLineId')
                                                                {{$photoLine->id}}
                                                            @endslot
                                                            @slot('class')
                                                                {{$photoLine->is_approved ? 'danger' : 'success'}}
                                                            @endslot
                                                            @slot('buttonText')
                                                                {{$photoLine->is_approved ? 'Reject' : 'Approve'}}
                                                            @endslot
                                                            @slot('isChecked')
                                                                {{$photoLine->is_approved ? 'checked' : ''}}
                                                            @endslot
                                                            @slot('path')
                                                                {{$photoLine->photo->path}}
                                                            @endslot
                                                        @endcomponent
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
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

@endsection
