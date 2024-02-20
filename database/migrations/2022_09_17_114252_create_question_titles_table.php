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
        Schema::create('question_titles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->uuid('category_id');
            $table->uuid('lesson_category_id');
            $table->uuid('lesson_id');
            $table->string('name');
            $table->integer('total_choices');
            $table->integer('total_section');
            $table->tinyInteger('add_value_category'); // 1 true, 0 false;
            $table->tinyInteger('assessment_type')->default(1); // 1 per question category, 2 all question, 3 point answer
            $table->double('passing_grade')->nullable();

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
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_titles');
    }
};
