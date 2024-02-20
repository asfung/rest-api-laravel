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
        Schema::create('career_tests', function (Blueprint $table) {
            $table->id();
            $table->string('career_code');
            $table->string('name');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('tree_lvl');
            $table->string('id_tree');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('career_tests');
    }
};
