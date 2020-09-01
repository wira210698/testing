<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbAnakMeninggalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_anak_meninggal', function (Blueprint $table) {
             $table->char('id',6)->primary()->unique();
            $table->char('anak_id',6);
            $table->foreign('anak_id')->references('id')->on('reg_anak');
            $table->date('tgl_kematian');
            $table->string('tempat',20);
            $table->string('usia_kematian',2);
            $table->string('penyebab_kematian',20);
            $table->string('ket',100);
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
        Schema::dropIfExists('tb_anak_meninggal');
    }
}
