<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommandeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commande_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('commande')
                ->constrained('commandes')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('product')
                ->constrained('products')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->integer('quantity',false,true)
                ->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commande_details');
    }
}
