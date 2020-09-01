<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbSasaranIbuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_sasaran_ibu', function (Blueprint $table) {
            $table->char('id',6);
            $table->char('dusun_id',6);
            $table->foreign('dusun_id')->references('id')->on('tb_dusun');
            $table->integer('bumil');
            $table->integer('bulin');
            $table->integer('bumil_resti');
            $table->char('periode',4);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_sasaran_ibu');
    }
}
