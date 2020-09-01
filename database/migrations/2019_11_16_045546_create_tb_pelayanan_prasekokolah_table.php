<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbPelayananPrasekokolahTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_pelayanan_prasekokolah', function (Blueprint $table) {
            $table->char('id',6);
            $table->char('anak_id',6);
            $table->foreign('anak_id')->references('id')->on('reg_anak');
            $table->date('tgl_pelayanan');
            $table->string('tempat',25);
            $table->string('status_gizi',15);
            $table->boolean('pemberian_arv');
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
        Schema::dropIfExists('tb_pelayanan_prasekokolah');
    }
}
