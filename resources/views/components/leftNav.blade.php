@auth
    @switch(auth()->user()->role_id)
        @case(\App\Role::admin())
        <li class="nav-item">
            <a class="nav-link" href="{{ action('OrderController@index')}}">
                Orders
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ action('ProductController@index')}}">
                Products
            </a>
        </li>
        @break
        @case(\App\Role::customer())
        <li class="nav-item">
            <a class="nav-link" href="{{ action('OrderController@create')}}">
                Order
            </a>
        </li>
        @break
        @default
    @endswitch
@endauth
