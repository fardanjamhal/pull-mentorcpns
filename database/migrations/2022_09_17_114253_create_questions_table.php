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
        Schema::create('questions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->softDeletes();
            $table->uuid('question_title_id');
            $table->uuid('value_category_id')->nullable();

            $table->tinyInteger('audio_input')->default(0);
            $table->string('audio')->nullable();
            $table->tinyInteger('audio_played_limit')->nullable();
            $table->integer('audio_answer_time')->nullable();

            $table->text('question')->nullable();
            $table->text('option_1')->nullable();
            $table->text('option_2')->nullable();
            $table->text('option_3')->nullable();
            $table->text('option_4')->nullable();
            $table->text('option_5')->nullable();

            $table->integer('point_1')->default(0);
            $table->integer('point_2')->default(0);
            $table->integer('point_3')->default(0);
            $table->integer('point_4')->default(0);
            $table->integer('point_5')->default(0);

            $table->integer('wrong_point')->default(0);
            $table->integer('correct_point')->default(1);
            $table->integer('answer')->default(0);
            $table->string('discussion_video')->nullable();
            $table->text('discussion')->nullable();
            $table->integer('section')->default(1);

            $table->foreign('question_title_id')
                  ->references('id')
                  ->on('question_titles')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('value_category_id')
                  ->references('id')
                  ->on('value_categories')
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
        Schema::dropIfExists('questions');
    }
};
