<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbKunjunganAnakTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_kunjungan_anak', function (Blueprint $table) {
            $table->char('id',6)->primary()->unique();
            $table->char('anak_id',6);
            $table->foreign('anak_id')->references('id')->on('reg_anak');
            $table->date('tgl_kunjungan');
            $table->string('kd_pelayanan',10);
            $table->string('tempat',25);
            $table->string('umur',2);
            $table->integer('bb');
            $table->string('kondisi_anak',);
            $table->string('kondisi_anak');
            $table->text('ket',100);
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
        Schema::dropIfExists('tb_kunjungan_anak');
    }
}
