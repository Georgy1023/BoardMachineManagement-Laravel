<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLicenseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('license_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('created_by');
            $table->string('role');
            $table->string('version_id')->nullable();
            $table->string('mac_address');
            $table->string('request_key')->nullable();
            $table->string('license');
            $table->string('note')->nullable();
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
        Schema::dropIfExists('license');
    }
}
