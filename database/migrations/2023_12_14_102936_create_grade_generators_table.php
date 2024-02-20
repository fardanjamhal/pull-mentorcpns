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
        Schema::create('grade_generators', function (Blueprint $table) {
            $table->id();
            
            $table->string('nama');
            $table->tinyInteger('gender');

            $table->integer('twk_ke')->nullable();
            $table->double('nilai_twk')->nullable();

            $table->integer('pu_ke')->nullable();
            $table->double('nilai_pu')->nullable();

            $table->integer('mtk_ke')->nullable();
            $table->double('nilai_mtk')->nullable();

            $table->integer('inggris_ke')->nullable();
            $table->double('nilai_inggris')->nullable();

            $table->integer('indonesia_ke')->nullable();
            $table->double('nilai_indonesia')->nullable();

            $table->double('nilai_akhir')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grade_generators');
    }
};
