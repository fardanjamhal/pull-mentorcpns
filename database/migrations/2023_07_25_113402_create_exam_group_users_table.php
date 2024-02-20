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
        Schema::create('exam_group_users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->uuid('user_id');
            $table->uuid('exam_group_id');
            
            $table->integer('duration')->nullable();
            $table->integer('section')->nullable();
            $table->integer('total_section')->nullable();
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->integer('total_correct')->nullable();

            $table->json('answers')->nullable();
            $table->integer('total_tolerance')->default(0)->nullable();
            $table->tinyInteger('is_blocked')->default(0)->nullable();
            $table->decimal('grade', 5, 2);
            $table->integer('is_finished')->default(0);
            $table->text('description')->nullable();
       
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreign('exam_group_id')
                  ->references('id')
                  ->on('exam_groups')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_group_users');
    }
};
