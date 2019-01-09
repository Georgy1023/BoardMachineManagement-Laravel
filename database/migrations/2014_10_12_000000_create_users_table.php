<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('user_name')->unique();
            $table->string('email')->nullable();
            $table->string('password');
            $table->string('origin_password');
            $table->string('phone')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('license')->default(0);
            $table->integer('startup')->default(0);
            $table->string('last_connection')->nullable();
            $table->string('role')->nullable();
            $table->boolean('activate')->default(true);
            $table->text('note')->nullable();
            $table->string('photo')->nullable();
            $table->string('status')->default(true);
            $table->string('user_real_name');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
