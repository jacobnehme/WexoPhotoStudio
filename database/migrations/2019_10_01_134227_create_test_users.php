<?php

use App\Customer;
use App\Photographer;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        User::create([
            'email' => 'admin@email.dk',
            'password' => Hash::make('pw123!'),
            'role_id' => 1
        ]);

        $photographer = User::create([
            'email' => 'photographer@email.dk',
            'password' => Hash::make('pw123!'),
            'role_id' => 2
        ]);

        Photographer::create([
            'user_id' => $photographer->id,
        ]);

        $customer = User::create([
            'email' => 'customer@email.dk',
            'password' => Hash::make('pw123!'),
            'role_id' => 3
        ]);

        Customer::create([
            'user_id' => $customer->id,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
