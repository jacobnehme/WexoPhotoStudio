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
                                                            @foreach($orderLine->photoLines as $photoLine)
                                                                <li data-target="#carouselExampleIndicators"
                                                                    data-slide-to="0"
                                                                    class="{{$loop->first ? 'active' : ''}}"></li>
                                                            @endforeach
                                                        </ol>
                                                        <div class="carousel-inner">
                                                            @foreach($orderLine->photoLines as $photoLine)
                                                                <div
                                                                    class="carousel-item {{$loop->first ? 'active' : ''}}">
                                                                    <div class="photo">
                                                                        <label
                                                                            class="btn-@if($photoLine->is_approved === null){{'warning'}}
                                                                            @else{{$photoLine->is_approved ? 'success' : 'danger'}}@endif">
                                                                            @if($photoLine->is_approved === null)
                                                                                Pending...
                                                                            @else
                                                                                {{$photoLine->is_approved ? 'Approved...' : 'Rejected...'}}
                                                                            @endif
                                                                        </label>
                                                                        <img class="img-fluid"
                                                                             src="{{asset('../storage/app/public/'.$photoLine->photo->path)}}"
                                                                             alt="">
                                                                    </div>

                                                                    {{--<form
                                                                        action="{{ action('PhotoLineController@update', $photoLine->id)}}"
                                                                        method="POST">
                                                                        @method('PATCH')
                                                                        @Csrf
                                                                        <label for="modal-status-{{$photoLine->id}}"
                                                                               class="btn btn-{{$photoLine->is_approved ? 'danger' : 'success'}}">
                                                                            {{$photoLine->is_approved ? 'Reject' : 'Approve'}}
                                                                            <input type="checkbox" name="status"
                                                                                   id="modal-status-{{$photoLine->id}}"
                                                                                   onchange="this.form.submit()"
                                                                                   {{$photoLine->is_approved ? 'checked' : ''}}
                                                                                   style="display: none">
                                                                        </label>
                                                                    </form>--}}
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
                                            <strong>Approved: </strong>{{$orderLine->approvedCount()}} / {{$orderLine->photoLines->count()}} <br>
                                        </td>
                                        <td class="col-md-8">
                                            <div class="row">
                                                @if($orderLine->product->photos->count())
                                                    @foreach($orderLine->product->photos as $photo)
                                                        @if(!$orderLine->photoLines->contains('photo_id', $photo->id))
                                                            <div class="col-md-3">
                                                                <div class="photo">
                                                                    <label
                                                                        class="btn-primary">
                                                                        Pre-shot...
                                                                    </label>
                                                                    <img class="img-fluid"
                                                                         src="{{asset('../storage/app/public/'.$photo->path)}}"
                                                                         alt="">
                                                                </div>
                                                                <form
                                                                    action="{{action('PhotoLineController@store')}}"
                                                                    method="POST">
                                                                    @Csrf
                                                                    <input type="hidden" name="orderLine_id"
                                                                           value="{{$orderLine->id}}">
                                                                    <input type="hidden" name="photo_id"
                                                                           value="{{$photo->id}}">
                                                                    <button type="submit" class="btn btn-primary">
                                                                        Add to order
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endif

                                                @if($orderLine->photoLines->count())

                                                    @foreach($orderLine->photoLines as $photoLine)


                                                        <div class="col-md-3">
                                                            <div class="photo" data-toggle="modal"
                                                                 data-target="#modal-{{$orderLine->id}}">
                                                                <label
                                                                    class="btn-@if($photoLine->is_approved === null){{'warning'}}
                                                                    @else{{$photoLine->is_approved ? 'success' : 'danger'}}@endif">
                                                                    @if($photoLine->is_approved === null)
                                                                        Pending...
                                                                    @else
                                                                        {{$photoLine->is_approved ? 'Approved...' : 'Rejected...'}}
                                                                    @endif
                                                                </label>
                                                                <img class="img-fluid"
                                                                     src="{{asset('../storage/app/public/'.$photoLine->photo->path)}}"
                                                                     alt="">
                                                            </div>
                                                            {{--@if($photoLine->is_approved === null)
                                                                <div class="buttons row">
                                                                    <form class="col-md-6 "
                                                                          action="{{ action('PhotoLineController@update', $photoLine->id)}}"
                                                                          method="POST">
                                                                        @method('PATCH')
                                                                        @Csrf
                                                                        <label for="status-approve-{{$photoLine->id}}"
                                                                               class="btn btn-success">
                                                                            Approve
                                                                            <input type="checkbox" name="status"
                                                                                   id="status-approve-{{$photoLine->id}}"
                                                                                   onchange="this.form.submit()"
                                                                                   checked}
                                                                                   style="display: none">
                                                                        </label>
                                                                    </form>
                                                                    <form class="col-md-6"
                                                                          action="{{ action('PhotoLineController@update', $photoLine->id)}}"
                                                                          method="POST">
                                                                        @method('PATCH')
                                                                        @Csrf
                                                                        <label for="status-reject-{{$photoLine->id}}"
                                                                               class="btn btn-danger">
                                                                            Reject
                                                                            <input type="checkbox" name="status"
                                                                                   id="status-reject-{{$photoLine->id}}"
                                                                                   onchange="this.form.submit()" }
                                                                                   style="display: none">
                                                                        </label>
                                                                    </form>
                                                                </div>
                                                            @else
                                                                <form
                                                                    action="{{ action('PhotoLineController@update', $photoLine->id)}}"
                                                                    method="POST">
                                                                    @method('PATCH')
                                                                    @Csrf
                                                                    <label for="status-{{$photoLine->id}}"
                                                                           class="btn btn-{{$photoLine->is_approved ? 'danger' : 'success'}}">
                                                                        {{$photoLine->is_approved ? 'Reject' : 'Approve'}}
                                                                        <input type="checkbox" name="status"
                                                                               id="status-{{$photoLine->id}}"
                                                                               onchange="this.form.submit()"
                                                                               {{$photoLine->is_approved ? 'checked' : ''}}
                                                                               style="display: none">
                                                                    </label>
                                                                </form>
                                                            @endif--}}

                                                            <form
                                                                action="{{ action('PhotoLineController@update', $photoLine->id)}}"
                                                                method="POST">
                                                                @method('PATCH')
                                                                @Csrf
                                                                <label for="status-{{$photoLine->id}}"
                                                                       class="btn btn-{{$photoLine->is_approved ? 'danger' : 'success'}}">
                                                                    {{$photoLine->is_approved ? 'Reject' : 'Approve'}}
                                                                    <input type="checkbox" name="status"
                                                                           id="status-{{$photoLine->id}}"
                                                                           onchange="this.form.submit()"
                                                                           {{$photoLine->is_approved ? 'checked' : ''}}
                                                                           style="display: none">
                                                                </label>
                                                            </form>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
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

@endsection
