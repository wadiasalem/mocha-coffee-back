<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client')
                ->constrained('clients')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('table_id')
                ->constrained('tables')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('normal',false,true)
                ->default(1);
            $table->integer('child',false,true)
                ->default(0);
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
        Schema::dropIfExists('reservations');
    }
}
