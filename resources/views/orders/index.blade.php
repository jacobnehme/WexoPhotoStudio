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
                Orders
            @endslot

            {{-- Table --}}
            @component('components.table')

                {{-- Table Header --}}
                @slot('head')
                    <th class="col-md-2">Order ID</th>
                    <th class="col-md-2">Status</th>
                    <th class="col-md-2">Total</th>
                    <th class="col-md-3">Created</th>
                    <th class="col-md-3">Options</th>
                @endslot

                @foreach($orders as $order)
                    <tr class="row">
                        <td class="col-md-2">
                            #{{$order->id}}
                        </td>
                        <td class="col-md-2">
                            {{$order->approvedcount()}} / {{$order->orderLines()->count()}}
                        </td>
                        <td class="col-md-2">
                            kr. {{$order->total()}}
                        </td>
                        <td class="col-md-3">
                            {{date('j F, Y', strtotime($order->created_at))}}
                        </td>
                        <td class="col-md-3">
                            <a href="{{ action('OrderController@show', $order->id)}}">Details</a>
                            @if(auth()->user()->isRole('admin') and $order->confirmed)
                                <form action="{{ action('OrderController@update', $order->id)}}"
                                      method="POST">
                                    @method('PATCH')
                                    @csrf

                                    <div class="form-group row">
                                        <select name="photographer_id"
                                                class="form-control"
                                                onchange="this.form.submit()">
                                            <option selected hidden disabled>Choose...</option>
                                            @foreach(\App\Photographer::all() as $photographer)
                                                <option
                                                    value="{{$photographer->id}}"
                                                    {{$photographer->id == $order->photographer_id ? 'selected' : ''}}>
                                                    {{$photographer->user()->email}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endcomponent
        @endcomponent
    @endcomponent
@endcomponent
