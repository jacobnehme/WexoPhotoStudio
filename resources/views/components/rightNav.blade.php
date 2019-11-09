@switch(auth()->user()->role_id)
    @case(\App\Role::customer())
    <a class="dropdown-item" href="{{ action('OrderController@index')}}">
        My Orders
    </a>
    <a class="dropdown-item"
       href="{{ action('CustomerController@edit',  auth()->user()->customer()->id)}}">
        My Account
    </a>
    @break
    @case(\App\Role::photographer())
    <a class="dropdown-item" href="{{ action('OrderController@index')}}">
        My Orders
    </a>
    <a class="dropdown-item"
       href="{{ action('PhotographerController@edit',  auth()->user()->photographer()->id)}}">
        My Account
    </a>
    @break
    @default
@endswitch
