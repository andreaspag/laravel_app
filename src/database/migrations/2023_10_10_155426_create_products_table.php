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
            $table->id();
            $table->string('name', 10)->nullable(false);
            $table->string('code')->nullable(false);
            $table->unsignedBigInteger('category_id');
            $table->decimal('price');
            $table->dateTime('release_date')->nullable(false);
            $table->timestamps();
            $table->unique('code');
            $table->foreign('category_id')->references('id')->on('categories')->cascadeOnDelete();
            $table->index('category_id');
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
