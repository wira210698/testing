<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbDocTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_doc', function (Blueprint $table) {
            $table->char('id',6)->unique()->primary();
            $table->string('img',100);
            $table->string('judul',100);
            $table->string('kategori',100);
            $table->string('subjek',100);
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
        Schema::dropIfExists('tb_doc');
    }
}
