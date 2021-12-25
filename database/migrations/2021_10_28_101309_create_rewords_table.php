<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRewordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rewords', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image');
            $table->text('description');
            $table->integer('points',false,true);
            $table->dateTime('date_start');
            $table->dateTime('date_end');
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
        Schema::dropIfExists('rewords');
    }
}
