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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->string('image');
            $table->boolean('is_published')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->string('url');
            $table->string('github_url');
            $table->string('stack');
            $table->string('start_date');
            $table->string('end_date');
            $table->string('type');
            $table->string('role');
            $table->string('client');
            $table->string('client_url');
            $table->string('client_location');
            $table->string('client_industry');
            $table->string('client_description');
            $table->string('client_logo');

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
        Schema::dropIfExists('projects');
    }
};
