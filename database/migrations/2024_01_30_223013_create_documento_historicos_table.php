<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documento_historicos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('documento_id');
            $table->unsignedBigInteger('tipo_documento_id');
            $table->unsignedBigInteger('destinatario_user_id');
            $table->text('corpo_texto');
            $table->string('titulo');
            $table->string('descricao');
            $table->date("data_prazo");
            $table->time("horario_prazo");
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
        Schema::dropIfExists('documento_historicos');
    }
};
