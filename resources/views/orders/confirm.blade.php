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
                Confirm Product Info
            @endslot

            {{-- Table --}}
            @component('components.table')

                {{-- Table Header --}}
                @slot('head')
                    <th class="col-md-3">Barcode</th>
                    <th class="col-md-3">Title</th>
                    <th class="col-md-3">Description</th>
                    <th class="col-md-3"></th>
                @endslot

                <tr id="add-product-row" class="row">
                    <td class="col-md-3">
                        <div class="form-group">
                            <input class="form-control" type="text" name="barcode" value="">
                        </div>
                    </td>
                    <td class="col-md-3">
                        <div class="form-group">
                            <input class="form-control" type="text" name="title" value="">
                        </div>
                    </td>
                    <td class="col-md-3">
                        <div class="form-group">
                            <input class="form-control" type="text" name="description" value="">
                        </div>
                    </td>
                    <td class="col-md-3">
                        <button id="add-product-btn" class="btn btn-success" type="button" style="width: 60%">Add
                            Product
                        </button>
                    </td>
                </tr>

            @endcomponent

            <form id="add-product-form" method="POST" action="{{ action('OrderController@store')}}">
                @csrf

                {{-- Table --}}
                @component('components.table')

                    {{-- Table Header --}}
                    @slot('head')
                        <th class="col-md-4">Products</th>
                        {{--                        <th class="col-md-4">Title</th>--}}
                        {{--                        <th class="col-md-4">Description</th>--}}
                    @endslot

                    @foreach($products as $index => $product)

                        <tr class="row">
                            <td class="col-md-3">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="{{$index}}[barcode]"
                                           value="{{$product['barcode']}}" required>
                                </div>
                            </td>
                            <td class="col-md-3">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="{{$index}}[title]"
                                           value="{{$product['title']}}" required>
                                </div>
                            </td>
                            <td class="col-md-3">
                                <div class="form-group">
                                    <input class="form-control" type="text" name="{{$index}}[description]"
                                           value="{{$product['description']}}" required>
                                </div>
                            </td>
                            <td class="col-md-3">
                                <button class="btn btn-danger remove-product-btn" onclick="$(this).parents('tr.row').remove();" type="button"
                                        style="width: 60%">Remove Product
                                </button>
                            </td>
                        </tr>
                    @endforeach

                    {{--                                        @for($i = 1; $i < count($products); $i++)
                                                                <tr class="row">
                                                                    <td class="col-md-4">
                                                                        <div class="form-group">
                                                                            <input class="form-control" type="text" name="{{$i}}['barcode']" value="{{$products[$i]['barcode']}}" required>
                                                                        </div>
                                                                    </td>
                                                                    <td class="col-md-4">
                                                                        <div class="form-group">
                                                                            <input class="form-control" type="text" name="{{$i}}['title']" value="{{$products[$i]['title']}}" required>
                                                                        </div>
                                                                    </td>
                                                                    <td class="col-md-4">
                                                                        <div class="form-group">
                                                                            <input class="form-control" type="text" name="{{$i}}['description']" value="{{$products[$i]['description']}}" required>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endfor--}}
                @endcomponent

                <div class="form-group row justify-content-center">
                    <button type="submit" class="btn btn-primary">
                        Confirm
                    </button>
                </div>
            </form>

            @endcomponent
    @endcomponent
@endcomponent
