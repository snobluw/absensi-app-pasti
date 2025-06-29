<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKategoriAbsensisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kategori_absensis', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('gaji');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kategori_absensis');
    }
}
