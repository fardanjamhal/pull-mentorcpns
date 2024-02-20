<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->uuid('category_id');
            $table->uuid('lesson_category_id');
            $table->uuid('lesson_id');
            $table->uuid('exam_id');
            $table->uuid('exam_group_id')->nullable();
            $table->uuid('user_id');
            $table->integer('duration')->nullable();
            $table->integer('section')->default(1);
            $table->integer('total_section');
            $table->dateTime('start_time')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->time('work_duration')->nullable();
            $table->integer('total_correct')->default(0);
            $table->json('total_correct_per_section')->nullable();
            $table->double('percentage_grade')->nullable();
            $table->decimal('grade', 5, 2)->default(0);
            $table->double('final_grade')->nullable();
            $table->json('answers')->nullable();
            $table->json('grade_details')->nullable();
            $table->integer('is_finished')->default(0)->nullable();
            $table->integer('grade_calculate')->default(0);
            $table->integer('total_tolerance')->default(0)->nullable();
            $table->tinyInteger('is_blocked')->default(0)->nullable();

            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('lesson_category_id')
                  ->references('id')
                  ->on('lesson_categories')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('lesson_id')
                  ->references('id')
                  ->on('lessons')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('exam_id')
                  ->references('id')
                  ->on('exams')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('exam_group_id')
                  ->references('id')
                  ->on('exam_groups')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grades');
    }
};
