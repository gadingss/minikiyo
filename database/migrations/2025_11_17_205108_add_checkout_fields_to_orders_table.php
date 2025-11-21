<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {

            if (!Schema::hasColumn('orders', 'subtotal')) {
                $table->decimal('subtotal', 12, 2)->after('status');
            }

            if (!Schema::hasColumn('orders', 'discount_amount')) {
                $table->decimal('discount_amount', 12, 2)->default(0)->after('subtotal');
            }

            if (!Schema::hasColumn('orders', 'promo_code_id')) {
                $table->unsignedBigInteger('promo_code_id')->nullable()->after('discount_amount');
                $table->foreign('promo_code_id')->references('id')->on('promo_codes')->onDelete('set null');
            }

            if (!Schema::hasColumn('orders', 'delivery_fee')) {
                $table->decimal('delivery_fee', 12, 2)->default(0)->after('promo_code_id');
            }

            if (!Schema::hasColumn('orders', 'delivery_option')) {
                $table->string('delivery_option')->default('takeaway')->after('delivery_fee');
            }

            if (!Schema::hasColumn('orders', 'shipping_address')) {
                $table->text('shipping_address')->nullable()->after('delivery_option');
            }
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['promo_code_id']);
            $table->dropColumn([
                'subtotal',
                'discount_amount',
                'promo_code_id',
                'delivery_fee',
                'delivery_option',
                'shipping_address'
            ]);
        });
    }

};
