<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 'mac_address', 'producer', 'sub_version','version_id','activated','wibu_serial','request_key',
        // 'license_code_requested_num','last_license_code_requested','startup_code_requested_num','last_startup_code_requested',
        // 'sold_rented_to','note'
        Schema::create('boards', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mac_address')->unique();
            $table->string('producer');
            $table->string('startup_period');
            $table->string('sub_version')->nullable();
            $table->string('version_id')->nullable();
            $table->boolean('activated')->default(true);
            $table->string('wibu_serial')->nullable();
            $table->string('request_key')->nullable();
            $table->integer('license_code_requested_num')->default(0);
            $table->dateTime('last_license_code_requested')->nullable();
            $table->integer('startup_code_requested_num')->default(0);
            $table->dateTime('last_startup_code_requested')->nullable();
            $table->string('master')->nullable();
            $table->string('customer')->nullable();
            $table->string('client')->nullable();
            $table->string('note')->nullable();
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
        Schema::dropIfExists('boards');
    }
}
