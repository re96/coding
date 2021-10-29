<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->comment('아이디');
            $table->string('name', 20)->default('')->comment('이름');
            $table->string('nickname', 30)->default('')->comment('별명');
            $table->string('password', 60)->default('')->comment('비밀번호');
            $table->string('phone', 20)->default('')->comment('전화번호');
            $table->string('email', 100)->default('')->comment('이메일');
            $table->enum('gender', ['M', 'F'])->nullable()->comment('성별');

            $table->timestamp('created_at')->useCurrent()->comment('생성 일시');

            $table->unique('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
