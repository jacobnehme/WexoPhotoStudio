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
                Order
            @endslot

            <form method="POST" action="{{ action('OrderController@confirm')}}" enctype="multipart/form-data">
                @csrf

                <div class="form-group row">
                    <label for="products" class="col-md-4 col-form-label text-md-right">Upload CSV</label>

                    <div class="col-md-6">
                        <input id="products" type="file"
                               class="form-control{{ $errors->has('products') ? ' is-invalid' : '' }}"
                               name="products" value="{{ old('products') }}"
                               style="padding: 0; height: auto" required>

                        @if ($errors->has('products'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('products') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            Upload
                        </button>
                        <a href="/order" class="btn btn-warning">Manual</a>
                    </div>
                </div>
            </form>


        @endcomponent
    @endcomponent
@endcomponent
