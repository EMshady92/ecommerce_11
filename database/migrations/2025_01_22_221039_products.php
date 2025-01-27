<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->double('price',9,2)->nullable(); //centavos mas 9 digitos y 2 puntos decimales
            $table->double('oldprice',9,2)->default(0); //centavos mas 9 digitos y 2 puntos decimales
            $table->string('image_url')->nullable();
            $table->string('extension')->nullable();
            $table->string('categoria');
            $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
