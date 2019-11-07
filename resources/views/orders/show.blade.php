@component('components.layout')

    {{-- Content --}}
    @component('components.content')

        {{-- Width of content (1-12) --}}
        @slot('col')
            9
        @endslot

        {{-- Card --}}
        @component('components.card')

            {{-- Card Header --}}
            @slot('cardHeader')
                Order: #{{$order->id}}
            @endslot

            {{-- Table --}}
            @component('components.table')

                {{-- Table Header --}}
                @slot('head')
                    <th class="col-md-3">Product</th>
                    <th class="col-md-9">Photos</th>
                @endslot

                {{-- Modal and row for each OrderLine --}}
                @foreach($order->orderLines() as $orderLine)

                    {{-- Modals (Contains Carousel) --}}
                    @component('components.modal')
                        @slot('id')
                            {{$orderLine->id}}
                        @endslot
                        @slot('title')
                            {{$orderLine->product()->id}}
                        @endslot

                        {{-- Carousel --}}
                        @component('components.carousel')

                            @slot('id')
                                {{$orderLine->id}}
                            @endslot

                            {{-- Indicators for each photo on Carousel TODO Refactor --}}
                            @slot('indicators')

                                {{-- Foreach photo not on order (Adv. approval) TODO Refactor --}}
                                @foreach($orderLine->product()->photos() as $index => $photo)
                                    @if(!$orderLine->photoLines()->contains('photo_id', $photo->id))
                                        <li data-target="carousel-{{$orderLine->id}}"
                                            data-slide-to="{{$index}}"
                                            class="{{$loop->first ? 'active' : ''}}"></li>
                                    @endif
                                @endforeach

                                {{-- Foreach photo on order TODO Refactor --}}
                                @foreach($orderLine->photoLines() as $index => $photo)
                                    <li data-target="carousel-{{$orderLine->id}}"
                                        data-slide-to="{{$index}}"
                                        class="{{$loop->first ? 'active' : ''}}"></li>
                                @endforeach
                            @endslot

                            {{-- Carousel Items for each photo TODO Refactor--}}
                            {{-- Foreach photo not on order (Adv. approval) TODO Refactor --}}
                            @foreach($orderLine->product()->photos() as $photo)
                                @if(!$orderLine->photoLines()->contains('photo_id', $photo->id))
                                    <div
                                        class="carousel-item {{$loop->first ? 'active' : ''}}">
                                        @component('components/photo')
                                            @slot('orderLineId')
                                                {{null}}
                                            @endslot
                                            @slot('path')
                                                {{$photo->path}}
                                            @endslot
                                        @endcomponent
                                    </div>
                                @endif
                            @endforeach

                            {{-- Foreach photo on order TODO Refactor --}}
                            @foreach($orderLine->photoLines() as $photoLine)
                                <div
                                    class="carousel-item {{$loop->first ? 'active' : ''}}">
                                    @component('components/photo')
                                        @slot('orderLineId')
                                            {{$orderLine->id}}
                                        @endslot
                                        @slot('path')
                                            {{$photoLine->photo()->path}}
                                        @endslot
                                    @endcomponent
                                </div>
                            @endforeach
                        @endcomponent
                    @endcomponent

                    {{-- Rows --}}
                    <tr class="row" id="order-line-{{$orderLine->id}}">

                        {{-- First Column: OrderLine Info --}}
                        <td class="col-md-3">
                            <strong>OrderLine: </strong>#{{$orderLine->id}} <br>
                            <strong>Barcode: </strong>#{{$orderLine->product()->barcode}} <br>
                            <strong>Title: </strong>{{$orderLine->product()->title}} <br>

                            {{-- Status of the OrderLine --}}
                            @component('components.statusLabel')
                                @slot('class')
                                    @switch($orderLine->status_id)
                                        @case(\App\Status::pending())
                                        warning
                                        @break
                                        @case(\App\Status::rejected())
                                        danger
                                        @break
                                        @case(\App\Status::approved())
                                        success
                                        @break
                                    @endswitch
                                @endslot
                                @slot('labelText')
                                    @switch($orderLine->status_id)
                                        @case(\App\Status::pending())
                                        Pending...
                                        @break
                                        @case(\App\Status::rejected())
                                        Rejected...
                                        @break
                                        @case(\App\Status::approved())
                                        Approved...
                                        @break
                                    @endswitch
                                @endslot
                            @endcomponent

                            {{-- Approve/Reject Button for Customers --}}
                            @if(auth()->user()->isRole('customer'))
                                @component('components.statusForm')
                                    @slot('visible')
                                        @if(!$orderLine->photoLines()->count() > 0)
                                            display: none;
                                        @endif
                                    @endslot
                                    @slot('action')
                                        {{'OrderLineController@update'}}
                                    @endslot
                                    @slot('orderLineId')
                                        {{$orderLine->id}}
                                    @endslot
                                    @slot('class')
                                        {{$orderLine->isStatus('approved') ? 'danger' : 'success'}}
                                    @endslot
                                    @slot('buttonText')
                                        {{$orderLine->isStatus('approved') ? 'Reject' : 'Approve'}}
                                    @endslot
                                    @slot('isChecked')
                                        {{$orderLine->isStatus('approved') ? 'checked' : ''}}
                                    @endslot
                                @endcomponent
                            @endif
                        </td>

                        {{-- Second Column: Photos --}}
                        <td class="col-md-9">
                            <div class="row photos">

                                {{-- Foreach photo not on order (Adv. approval) TODO Refactor --}}
                                @foreach($orderLine->product()->photos() as $photo)
                                    @if(!$orderLine->photoLines()->contains('photo_id', $photo->id))

                                        {{-- Displays col divided by 12 number of photos on each row --}}
                                        <div class="col-md-3">
                                            @component('components/photo')
                                                @slot('orderLineId')
                                                    {{$orderLine->id}}
                                                @endslot
                                                @slot('path')
                                                    {{$photo->path}}
                                                @endslot
                                            @endcomponent
                                        </div>
                                    @endif
                                @endforeach

                                {{-- Foreach photo on order TODO Refactor --}}
                                @foreach($orderLine->photoLines() as $photoLine)
                                    <div class="col-md-3">
                                        @component('components/photo')
                                            @slot('orderLineId')
                                                {{$orderLine->id}}
                                            @endslot
                                            @slot('path')
                                                {{$photoLine->photo()->path}}
                                            @endslot
                                        @endcomponent
                                    </div>
                                @endforeach
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endcomponent
        @endcomponent
    @endcomponent
@endcomponent
