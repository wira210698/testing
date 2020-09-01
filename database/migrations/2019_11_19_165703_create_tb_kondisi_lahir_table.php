<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbKondisiLahirTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_kondisi_lahir', function (Blueprint $table) {
            $table->char('id',6)->primary()->unique();
            $table->char('anak_id',6);
            $table->foreign('anak_id')->references('id')->on('reg_anak');
            $table->date('tgl_pelayanan');
            $table->string('tempat',25);
            $table->string('kd_kondisi',25);
            $table->string('kd_pelayanan',25);
            $table->string('ket',100);
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
        Schema::dropIfExists('tb_kondisi_lahir');
    }
}
