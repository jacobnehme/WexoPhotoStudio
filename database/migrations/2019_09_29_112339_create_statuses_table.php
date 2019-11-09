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
            $table->string('title')->unique();
            $table->timestamps();
        });

        Status::create([
            'title' => 'pending',
        ]);
        Status::create([
            'title' => 'active',
        ]);
        Status::create([
            'title' => 'rejected',
        ]);
        Status::create([
            'title' => 'approved',
        ]);
        Status::create([
            'title' => 'pre-approved',
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
