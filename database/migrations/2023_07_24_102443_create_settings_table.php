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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('app_name');
            $table->string('app_url');
            $table->string('whatsapp_number');
            $table->string('whatsapp_token');
            $table->text('address');
            $table->string('logo')->nullable();
            $table->string('signed_name');
            $table->string('signed_image');
            $table->tinyInteger('add_activation_user')->default(0);
            $table->tinyInteger('purchase_type'); // 1 by exam, 2 by voucher, 3 by exam & voucher
            $table->json('payment_methods')->nullable();
            $table->tinyInteger('login_type')->default(1); // 1 email, 2 username, 3 email / username
            $table->integer('theme')->default(1);
            $table->integer('add_data_detail_for_registration')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
