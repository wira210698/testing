<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbIbuMenyusuiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_ibu_menyusui', function (Blueprint $table) {
            $table->char('id',5)->primary()->unique();
            $table->char('ibu_id',6);
            $table->foreign('ibu_id')->references('id')->on('reg_ibu');
            $table->date('tgl_nifas');
            $table->string('ket',100);
            $table->string('preode_nifas',20);
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
        Schema::dropIfExists('tb_ibu_menyusui');
    }
}
