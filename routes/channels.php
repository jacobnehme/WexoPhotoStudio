<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

use App\Order;
use App\Role;
use App\Status;

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

//Broadcast::channel('orders.{id}', function ($user, $id) {
//    $order = Order::where('id', $id)->get()->first();
//    switch ($user->role_id){
//        case Role::admin():
//            return $user->isRole('admin');
//            break;
//        case Role::photographer():
//            return $user->photographer()->id === $order->photographer_id;
//            break;
//        case Role::customer():
//            return $user->customer()->id === $order->customer_id;
//            break;
//    }
//});
