<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shop')
                    ->constrained('shops')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->foreignId('gift')
                    ->constrained('gifts')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_details');
    }
}
