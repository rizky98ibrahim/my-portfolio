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
        Schema::create('education', function (Blueprint $table) {
            $table->id();
            $table->string('degree_name');
            $table->string('institution_name');
            $table->string('institution_address');
            $table->string('institution_url');
            $table->string('start_date');
            $table->string('end_date');
            $table->string('gpa');
            $table->string('description')->nullable();
            $table->boolean('is_completed')->default(false);

            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('education');
    }
};
