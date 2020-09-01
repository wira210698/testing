<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbKunjunganKbTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_kunjungan_kb', function (Blueprint $table) {
            $table->char('id',6)->primary()->unique();
            $table->char('kb_id',6);
            $table->foreign('kb_id')->references('id')->on('reg_keluarga_berencana');
            $table->date('tgl_kunjungan');
            $table->string('jenis_kb',20);
            $table->text('ket')->nullable();
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
        Schema::dropIfExists('tb_kunjungan_kb');
    }
}
