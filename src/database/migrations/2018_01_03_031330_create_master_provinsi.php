<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMasterProvinsi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_provinsi', function (Blueprint $table) {
            $table->increments('provinsi_id');
            $table->string('provinsi_kode');
            $table->string('provinsi_nama');
            $table->integer('provinsi_create_by');
            $table->date('provinsi_create_date');
            $table->integer('provinsi_status');
            $table->integer('provinsi_log_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('master_provinsi');
    }
}
