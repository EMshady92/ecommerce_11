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
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("shopping_cart_id")->nullable()->unique();
            $table->integer("total")->default(0);
            $table->integer("guide_number")->nullable();

            $table->string("email")->default('');
            $table->string("line1")->default("");
            $table->string("line2")->nullable(true);
            $table->string("city")->default("");
            $table->string("postal_code")->default("");
            $table->string("country_code")->default("");
            $table->string("state")->default("");
            $table->string("recipient_name")->default("");


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
