@component('components.layout')

    {{-- Content --}}
    @component('components.content')

        {{-- Width of content (1-12) --}}
        @slot('col')
            col-md-12 col-lg-9
        @endslot

        {{-- Card --}}
        @component('components.card')

            {{-- Card Header --}}
            @slot('cardHeader')
                Product: #{{$product->barcode}}
            @endslot

            {{-- Table --}}
            @component('components.table')

                {{-- Table Header --}}
                @slot('head')
                    <th class="col-md-3">Barcode</th>
                    <th class="col-md-3">Title</th>
                    <th class="col-md-3">Description</th>
                    <th class="col-md-3">Created</th>
                @endslot

                <tr class="row">
                    <td class="col-md-3">{{$product->barcode}}</td>
                    <td class="col-md-3">{{$product->title}}</td>
                    <td class="col-md-3">{{$product->description}}</td>
                    <td class="col-md-3">
                        {{date('j F, Y', strtotime($product->created_at))}}
                    </td>
                </tr>
            @endcomponent
        @endcomponent

        {{-- Card --}}
        @component('components.card')

            {{-- Card Header --}}
            @slot('cardHeader')
                All Photos
            @endslot

            <div class="row">
                @foreach($product->photos() as $photo)
                    <div class="col-md-3">
                        @component('components.photo')
                            @slot('orderLineId')
                                null
                            @endslot
                            @slot('path')
                                {{$photo->path}}
                            @endslot
                        @endcomponent
                    </div>
                @endforeach
            </div>
        @endcomponent
    @endcomponent
@endcomponent
