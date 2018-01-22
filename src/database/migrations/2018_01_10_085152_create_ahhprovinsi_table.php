<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAhhprovinsiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ahhprovinsi', function (Blueprint $table) {
            $table->increments('ahhprovinsiid');
            $table->string('ahhprovinsivalue');
            $table->date('ahhprovinsitgl');
            $table->string('ahhprovinsiprovincekode');
            $table->string('ahhprovinsikotakode');
            $table->date('ahhprovinsicreatedate');
            $table->integer('ahhprovinsicreateby');
            $table->integer('ahhprovinsistatus');
            $table->integer('ahhprovinsilogid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ahhprovinsi');
    }
}
