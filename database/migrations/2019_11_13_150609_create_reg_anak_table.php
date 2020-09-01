<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegAnakTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reg_anak', function (Blueprint $table) {
            $table->char('id',6)->primary()->unique();
            $table->foreign('dusun_id')->references('id')->on('tb_dusun');
            $table->char('NIK',16)->unique();
            $table->string('nama_ibu',200);
            $table->string('nama_anak',200);
            $table->string('status',100);
            $table->date('tgl_lahir');
            $table->string('umur',12);
            $table->char('dusun_id',5);
            $table->boolean('jk');
            $table->boolean('buku_KIA');
            $table->text('ket');
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
        Schema::dropIfExists('reg_anak');
    }
}
