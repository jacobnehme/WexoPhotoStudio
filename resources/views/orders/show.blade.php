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
            @component('components.customTable')

                {{-- Table Header --}}
                @slot('head')
                    <div class="col-md-3"><strong>Customer: </strong> <br>
                        {{$order->customer()->user()->email}}
                    </div>
                    <div class="col-md-3"><strong>Photographer: </strong> <br>
                        {{$order->photographer_id != null ? $order->photographer()->user()->email : 'Pending...'}}
                    </div>
                @endslot

                {{-- Modal and row for each OrderLine --}}
                @foreach($order->orderLines() as $orderLine)

                    {{-- OrderLine Row --}}
                    <div id="order-line-{{$orderLine->id}}" class="order-line">

                        <div class="row details">

                            {{-- Status of the OrderLine --}}
                            <div class="col-md-2">
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
                                            @case(\App\Status::preApproved())
                                            primary
                                            @break
                                        @endswitch
                                    @endslot
                                    @slot('labelText')
                                        {{ucfirst($orderLine->status()->title)}}...
                                    @endslot
                                @endcomponent
                            </div>

                            {{-- Product Title --}}
                            <div class="col-md-3"><strong>Title: </strong>{{$orderLine->product()->title}}</div>

                            {{-- More info for Photographer --}}
                            {{--                            @if(!auth()->user()->isRole('customer'))--}}
                            <div class="col-md-3"><strong>Barcode: </strong>#{{$orderLine->product()->barcode}}
                            </div>
                            <div class="col-md-3"><strong>OrderLine: </strong>#{{$orderLine->id}}</div>
                            {{--                            @endif--}}

                            <div class="col-md-1">
                                <button class="toggle btn btn-primary" data-id="{{$orderLine->id}}">---</button>
                            </div>
                        </div>

                        <div class="content">

                            <div class="row">

                                {{-- First Column: Photos --}}
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

                                {{-- Second Column: Buttons --}}
                                <div class="buttons">

                                    {{-- Approve/Reject Button for Customers TODO and $orderLine->isStatus('pending' --}}
                                    @if(auth()->user()->isRole('customer') and $orderLine->isStatus('pending'))

                                        {{-- Approve/Reject --}}
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
                                                success
                                            @endslot
                                            @slot('buttonText')
                                                Approve
                                            @endslot
                                            @slot('status')
                                                {{\App\Status::approved()}}
                                            @endslot
                                        @endcomponent

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
                                                danger
                                            @endslot
                                            @slot('buttonText')
                                                Reject
                                            @endslot
                                            @slot('status')
                                                {{ \App\Status::rejected() }}
                                            @endslot
                                        @endcomponent
                                    @endif
                                </div>

                            </div>

                            {{-- Rows for pre-approval --}}
                            <div class="pre-approval">

                                @if(auth()->user()->isRole('customer'))
                                    @foreach($orderLine->product()->orderLines() as $ol)

                                        {{-- Long If TODO Refactor --}}
                                        @if(
                                        //Show if OrderLine is not approved
                                        !$orderLine->isStatus('approved') and
                                        //Only show OrderLines that have been approved
                                        $ol->isStatus('approved') and
                                        //Do not show this OrderLine for pre-approval
                                        $ol->id != $orderLine->id and
                                        //Do not show duplicate OrderLines*
                                        !$orderLine->photoLines()->contains('photo_id', $ol->photoLines()->first()->photo_id)
                                        )

                                            <div id="order-line-{{$ol->id}}" class="row">

                                                {{-- First Column: Photos --}}
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

                                                {{-- Second Column: Buttons --}}
                                                <div class="buttons">

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
                                                                {{$orderLine->id}}
                                                            @endslot
                                                            @slot('class')
                                                                primary
                                                            @endslot
                                                            @slot('buttonText')
                                                                Pre-Approve
                                                            @endslot
                                                            @slot('status')
                                                                {{\App\Status::preApproved()}}
                                                            @endslot

                                                            @foreach($ol->photoLines() as $photoLine)
                                                                <input type="hidden" name="photos[]"
                                                                       value="{{$photoLine->photo_id}}">
                                                            @endforeach
                                                        @endcomponent
                                                    @endif
                                                </div>

                                            </div>

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

                                                    {{-- Indicators for each photo on Carousel --}}
                                                    @slot('indicators')
                                                        @foreach($ol->photoLines() as $index => $photo)
                                                            <li data-target="carousel-{{$ol->id}}"
                                                                data-slide-to="{{$index}}"
                                                                class="{{$loop->first ? 'active' : ''}}"></li>
                                                        @endforeach
                                                    @endslot

                                                    {{-- Carousel Items for each photo --}}
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
                                        @endif
                                    @endforeach
                                @endif
                            </div>

                        </div>

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

                                {{-- Indicators for each photo --}}
                                @slot('indicators')
                                    @foreach($orderLine->photoLines() as $index => $photo)
                                        <li data-target="carousel-{{$orderLine->id}}"
                                            data-slide-to="{{$index}}"
                                            class="{{$loop->first ? 'active' : ''}}"></li>
                                    @endforeach
                                @endslot

                                {{-- Carousel Items for each photo --}}
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
                    </div>
                @endforeach
            @endcomponent
        @endcomponent
    @endcomponent
@endcomponent
