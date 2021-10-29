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
            $table->increments('id')->comment('아이디');
            $table->unsignedInteger('user_id')->comment('회원 아이디');
            $table->string('ord_no', 12)->default('')->comment('주문번호');
            $table->string('product_name', 100)->default('')->comment('제품명');

            $table->timestamp('paid_at')->comment('결제일시');
            $table->timestamp('created_at')->useCurrent()->comment('생성 일시');

            $table->foreign('user_id')->references('id')->on('users');

            $table->unique('ord_no');
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
