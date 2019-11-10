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
                Photographer
            @endslot

            <form method="POST" action="{{ action('PhotographerController@update', $photographer->id)}}">
                @method('PATCH')
                @csrf

                <div class="form-group row">
                    <label for="name-first" class="col-md-4 col-form-label text-md-right">Employee No.</label>

                    <div class="col-md-6">
                        <input id="name-first" type="text"
                               class="form-control{{ $errors->has('employee_no') ? ' is-invalid' : '' }}"
                               name="name_first" value="{{ $photographer->name_first }}" >

                        @if ($errors->has('employee_no'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('employee_no') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            Edit
                        </button>
                    </div>
                </div>
            </form>
        @endcomponent
    @endcomponent
@endcomponent
