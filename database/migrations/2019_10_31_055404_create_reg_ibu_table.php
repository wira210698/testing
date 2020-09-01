<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegIbuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reg_ibu', function (Blueprint $table) {
            $table->char('id',5)->unique()->primary();
            $table->char('NIK',16)->unique();
            $table->string('nama_ibu',100);
            $table->string('nama_suami',100);
            $table->string('dusun_id',10);
            $table->string('umur',2);
            $table->string('usia_hamil',2);
            $table->string('kehamilan_ke',2);
            $table->string('jrk_hamil',2);
            $table->float('bb');
            $table->float('tb');
            $table->string('td');
            $table->string('p_resiko',2)->nullable();
            $table->date('tgl_p_resiko')->nullable();
            $table->string('ket');
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
        Schema::dropIfExists('reg_ibu');
    }
}
