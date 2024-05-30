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
        Schema::create('follower_user', function (Blueprint $table) {
            /*this is a pivot table for users and followers , it has a many to many
            relationship. by default it doesnt have a model associated weith it , we
            only need to set two foreign keys, one for the user other for the follower */
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('follower_id')->constrained("users")->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follower_user');
    }
};
