<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->string('category')
                ->default('locally');
            $table->foreignId('employer')
                ->constrained('employers')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('table')
                ->constrained('tables')
                ->onUpdate('cascade')
                ->onDelete('cascade')
                ->nullable();
            $table->foreignId('client')
                ->constrained('clients')
                ->onUpdate('cascade')
                ->onDelete('cascade')
                ->nullable();
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
        Schema::dropIfExists('commandes');
    }
}
