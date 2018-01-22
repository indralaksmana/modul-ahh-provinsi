<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterKota extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_kota', function (Blueprint $table) {
            $table->increments('kota_id');
            $table->string('kota_provinsi_kode');
            $table->string('kota_kode');
            $table->string('kota_nama');
            $table->integer('kota_create_by');
            $table->date('kota_create_date');
            $table->integer('kota_status');
            $table->integer('kota_log_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('master_kota');
    }
}
