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
        Schema::create('ideas', function (Blueprint $table) {
            $table->id();
            $table->string("content");
            $table->foreignId("user_id")->constrained()->cascadeOnDelete();
            /*foreign id format is modelName_primaryKey */
            $table->unsignedInteger("likes")->default(0);
            $table->timestamps(); /*this creates a created at and updated at column timestamp in mysql */
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ideas');
    }
};
