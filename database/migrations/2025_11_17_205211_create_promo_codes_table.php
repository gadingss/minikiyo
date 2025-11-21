<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('type'); // percentage, fixed_amount
            $table->decimal('value', 10, 2); // 15 untuk 15%, atau 10000 untuk Rp 10.000
            $table->decimal('max_discount', 10, 2)->nullable(); // Maksimal diskon
            $table->decimal('min_order', 10, 2)->default(0); // Minimal order
            $table->integer('usage_limit')->nullable(); // Batas penggunaan
            $table->integer('used_count')->default(0); // Sudah berapa kali dipakai
            $table->dateTime('valid_from');
            $table->dateTime('valid_until');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('promo_codes');
    }
};