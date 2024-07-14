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
        Schema::create('webhook', function (Blueprint $table) {
            $table->id(); // Adds an auto-incrementing primary key column named 'id'
            $table->json('data'); // Adds a column named 'data' with JSON data type
            $table->timestamps(); // Adds 'created_at' and 'updated_at' timestamp columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('webhook');
    }
};
