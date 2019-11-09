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
                Products
            @endslot

            {{-- Table --}}
            @component('components.table')

                {{-- Table Header --}}
                @slot('head')
                    <th class="col-md-4">Barcode</th>
                    <th class="col-md-4">Title</th>
                    <th class="col-md-4">Options</th>
                @endslot

                @foreach($products as $product)
                    <tr class="row">
                        <td class="col-md-4">
                            {{$product->barcode}}
                        </td>
                        <td class="col-md-4">
                            {{$product->title}}
                        </td>
                        <td class="col-md-4">
                            <a href="{{ action('ProductController@show', $product->id)}}">Details</a>
                        </td>
                    </tr>
                @endforeach
            @endcomponent
        @endcomponent
    @endcomponent
@endcomponent
