<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null')->onUpdate('cascade');
            $table->string('billing_email');
            $table->string('billing_full_name');
            $table->string('billing_address');
            $table->string('billing_country');
            $table->string('billing_state');
            $table->string('billing_city');
            $table->string('billing_zip');
            $table->string('billing_phone');
            $table->string('billing_card_holder_name')->nullable();
            $table->float('billing_subtotal');
            $table->float('billing_tax');
            $table->float('billing_total');
            $table->float('billing_discount')->default(0);
            $table->string('billing_discount_code')->nullable();
            $table->string('payment_mode')->default('cash');
            $table->enum('status', ['processing', 'shipped', 'delivered'])->default('processing');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
