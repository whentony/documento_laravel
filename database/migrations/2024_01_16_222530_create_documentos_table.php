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
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tipo_documento_id');
            $table->unsignedBigInteger('reuniao_id')->nullable();
            $table->unsignedBigInteger('remetente_user_id');
            $table->unsignedBigInteger('destinatario_user_id');
            $table->unsignedBigInteger('resposta_documento_id')->nullable();
            $table->text('corpo_texto');
            $table->unsignedBigInteger('numero_documento')->nullable();
            $table->string('titulo');
            $table->string('descricao');
            $table->date("data_prazo");
            $table->time("horario_prazo");
            $table->dateTime("protocolo");
            $table->dateTime('visualizacao')->nullable();

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
        Schema::dropIfExists('documentos');
    }
};
