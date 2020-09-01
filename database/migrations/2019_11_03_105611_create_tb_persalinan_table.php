<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbPersalinanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_persalinan', function (Blueprint $table) {
            $table->char('id',5)->primary()->unique();
            $table->char('ibu_id',6);
            $table->foreign('ibu_id')->references('id')->on('reg_ibu');
            $table->date('tgl_persalinan');
            $table->string('tng_penolong');
            $table->string('jenis_kelahiran');
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
        Schema::dropIfExists('tb_persalinan');
    }
}
