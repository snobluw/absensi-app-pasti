<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAbsensisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained()->onDelete('cascade');
            $table->foreignId('kategori_absensi_id')->constrained()->onDelete('cascade');
            $table->foreignId('admin_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('tanggal');
            $table->enum('jenis_absensi', ['M', 'P'])->nullable()->comment('M = Masuk, P = Pulang');
            $table->enum('jenis', ['H', 'S', 'I', 'T'])->nullable()
          ->comment('H=Hadir, S=Sakit, I=Izin, T=Tanpa Keterangan');
            $table->string('bukti_photo')->nullable();
            $table->enum('status_validasi', ['M','N','Y']) ->comment('M=Menunggu, N=Tidak Valid, Y=Valid');;
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
        Schema::dropIfExists('absensis');
    }
}
