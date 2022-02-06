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
            $table->foreignId('employer')->nullable(true)
                ->constrained('employers')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('table_id')->nullable(true)
                ->constrained('tables')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('client')->nullable(true)
                ->constrained('clients')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamp('served_at')
                ->nullable(true)
                ->default(null);
            $table->integer('amount',false,false)
                ->default(0);
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
