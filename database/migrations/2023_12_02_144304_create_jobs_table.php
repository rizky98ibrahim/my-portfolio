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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('company_url');
            $table->string('company_logo');
            $table->string('job_title');
            $table->string('job_description');
            $table->string('job_location');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->boolean('is_published')->default(false);
            $table->boolean('is_current_job')->default(false);
            $table->boolean('is_ended_job')->default(false);
            $table->boolean('is_remote')->default(false);
            $table->boolean('is_freelance')->default(false);

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
        Schema::dropIfExists('jobs');
    }
};
