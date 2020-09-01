<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbImunisasiRegAnakTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_imunisasi_reg_anak', function (Blueprint $table) {
            $table->bigIncrements('id',6);
            $table->char('anak_id',6);
            $table->foreign('anak_id')->references('id')->on('reg_anak');
            $table->char('imunisasi_id',6);
            $table->foreign('imunisasi_id')->references('id')->on('tb_imunisasi');
            $table->date('tgl_kunjungan');
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
        Schema::dropIfExists('tb_imunisasi_reg_anak');
    }
}
