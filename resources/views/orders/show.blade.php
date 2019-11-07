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

                    <tr class="row">
                        <td class="col-md-3"><strong>OrderLine: </strong>#{{$orderLine->id}}</td>
                        <td class="col-md-3"><strong>Barcode: </strong>#{{$orderLine->product()->barcode}}</td>
                        <td class="col-md-3"><strong>Title: </strong>{{$orderLine->product()->title}}</td>

                    </tr>

                    {{-- OrderLine Row --}}
                    <tr class="row" id="order-line-{{$orderLine->id}}">

                        {{-- First Column: OrderLine Info --}}
                        <td class="col-md-3">

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
                                    {{ucfirst($orderLine->status()->title)}}...
                                @endslot
                            @endcomponent

                            {{-- Approve/Reject Button for Customers --}}
                            @if(auth()->user()->isRole('customer'))

                                {{-- Approve/Reject TODO Refactor --}}
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
                                    @slot('status')
                                        {{$orderLine->isStatus('approved') ? \App\Status::rejected() : \App\Status::approved()}}
                                    @endslot
                                @endcomponent
                            @endif
                        </td>

                        {{-- Second Column: Photos --}}
                        <td class="col-md-9">
                            <div class="row photos">
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

                    {{-- Rows for pre-approval --}}
                    @foreach($orderLine->product()->orderLines() as $ol)
                        @if($ol->photoLines()->count() > 0 and $orderLine->id != $ol->id)

                            {{-- Modals (Contains Carousel) --}}
                            @component('components.modal')
                                @slot('id')
                                    {{$ol->id}}
                                @endslot
                                @slot('title')
                                    {{$ol->product()->id}}
                                @endslot

                                {{-- Carousel --}}
                                @component('components.carousel')

                                    @slot('id')
                                        {{$ol->id}}
                                    @endslot

                                    {{-- Indicators for each photo on Carousel TODO Refactor --}}
                                    @slot('indicators')

                                        {{-- Foreach photo on order TODO Refactor --}}
                                        @foreach($ol->photoLines() as $index => $photo)
                                            <li data-target="carousel-{{$ol->id}}"
                                                data-slide-to="{{$index}}"
                                                class="{{$loop->first ? 'active' : ''}}"></li>
                                        @endforeach
                                    @endslot

                                    {{-- Carousel Items for each photo TODO Refactor--}}
                                    {{-- Foreach photo on order TODO Refactor --}}
                                    @foreach($ol->photoLines() as $photoLine)
                                        <div
                                            class="carousel-item {{$loop->first ? 'active' : ''}}">
                                            @component('components/photo')
                                                @slot('orderLineId')
                                                    {{$ol->id}}
                                                @endslot
                                                @slot('path')
                                                    {{$photoLine->photo()->path}}
                                                @endslot
                                            @endcomponent
                                        </div>
                                    @endforeach
                                @endcomponent
                            @endcomponent

                            <tr class="row" id="order-line-{{$ol->id}}">

                                {{-- First Column: OrderLine Info --}}
                                <td class="col-md-3">

                                    {{-- Approve/Reject Button for Customers --}}
                                    @if(auth()->user()->isRole('customer'))

                                        {{-- Pre-Approve TODO Refactor --}}
                                        @component('components.statusForm')
                                            @slot('visible')
                                            @endslot
                                            @slot('action')
                                                {{'OrderLineController@update'}}
                                            @endslot
                                            @slot('orderLineId')
                                                {{$ol->id}}
                                            @endslot
                                            @slot('class')
                                                primary
                                            @endslot
                                            @slot('buttonText')
                                                Pre-Approve
                                            @endslot
                                            @slot('status')
                                                {{\App\Status::approved()}}
                                            @endslot
                                        @endcomponent
                                    @endif
                                </td>

                                {{-- Second Column: Photos --}}
                                <td class="col-md-9">
                                    <div class="row photos">

                                        @foreach($ol->photoLines() as $photoLine)
                                            <div class="col-md-3">
                                                @component('components/photo')
                                                    @slot('orderLineId')
                                                        {{$ol->id}}
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
                        @endif
                    @endforeach
                @endforeach
            @endcomponent
        @endcomponent
    @endcomponent
@endcomponent
