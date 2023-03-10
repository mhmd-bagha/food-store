<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('coupon_id')->nullable();
            $table->string('total_amount', 20)->default(0);
            $table->string('delivery_amount', 10)->default(0);
            $table->string('taxation', 10)->default(0);
            $table->enum('status', ['waiting', 'paid', 'unpaid']);
            $table->string('ip');
            $table->string('create_at', 20);
            $table->string('update_at', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart');
    }
};
