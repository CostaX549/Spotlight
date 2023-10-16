<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('historico_visualizacoes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('media_id'); // Pode ser um movie_id ou serie_id
            $table->string('media_type'); // Indica se é um filme ou série
        
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
          
        });
    }

    public function down()
    {
        Schema::dropIfExists('historico_visualizacoes');
    }
};
