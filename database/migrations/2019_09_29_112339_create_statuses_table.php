<?php

use App\Status;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->increments('id');
            //$table->unsignedInteger('key')->nullable(true);
            $table->string('title');
            $table->timestamps();
        });

        Status::create([
            //'key' => 1,
            'title' => 'pending',
        ]);
        Status::create([
            //'key' => 2,
            'title' => 'rejected',
        ]);
        Status::create([
            //'key' => 3,
            'title' => 'approved',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statuses');
    }
}
