<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('courses', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('slug')->unique(); (Esencial para URLs amigables y SEO).
        $table->text('description');
        $table->string('instructor');
        $table->decimal('price', 8, 2)->default(0);
        $table->integer('duration')->comment('Duration in hours');
        $table->string('level')->default('beginner');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
