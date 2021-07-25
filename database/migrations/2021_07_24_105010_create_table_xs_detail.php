<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableXsDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('xs_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('xs_day_id');
            $table->string('origin', 10);
            $table->string('item', 10);
            $table->integer('number_order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_xs_detail');
    }
}
