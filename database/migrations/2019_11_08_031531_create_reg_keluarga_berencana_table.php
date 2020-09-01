<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegKeluargaBerencanaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reg_keluarga_berencana', function (Blueprint $table) {
            $table->char('id',6)->primary()->unique();
            $table->string('nama_ibu',200);
            $table->string('nama_suami',200);
            $table->string('umur',2);
            $table->string('jmlh_anak');
            $table->char('dusun_id',5);
            $table->foreign('dusun_id')->references('id')->on('tb_dusun');
            $table->string('riwayat_penyakit');
            $table->boolean('4T')->nullable();
            $table->boolean('gakin')->nullable();
            $table->date('pasca_bersalin')->nullable();
            $table->string('ket')->nullable();
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
        Schema::dropIfExists('reg_keluarga_berencana');
    }
}
