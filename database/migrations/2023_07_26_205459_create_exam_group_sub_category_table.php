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
        Schema::create('exam_group_sub_category', function (Blueprint $table) {
            $table->id();
            $table->uuid('exam_group_id');
            $table->uuid('sub_category_id');
            $table->timestamps();

            $table->foreign('exam_group_id')
                  ->references('id')
                  ->on('exam_groups')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

            $table->foreign('sub_category_id')
                  ->references('id')
                  ->on('sub_categories')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_group_sub_category');
    }
};
