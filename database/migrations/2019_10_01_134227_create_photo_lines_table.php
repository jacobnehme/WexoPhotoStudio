<?php

use App\Status;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotoLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photo_lines', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('order_line_id');
            $table->unsignedInteger('photo_id');
            $table->unsignedInteger('status_id')->default(Status::pending());
            $table->timestamps();

            $table->foreign('order_line_id')->references('id')->on('order_lines');
            $table->foreign('photo_id')->references('id')->on('photos');
            $table->foreign('status_id')->references('id')->on('statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('photo_lines');
    }
}
