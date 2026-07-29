<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('block_id')->unique()->constrained('blocks')->onDelete('cascade');
            $table->integer('efektivitas')->comment('Persentase efektivitas 0-100');
            $table->string('kategori')->comment('Efektif / Cukup Efektif / Kurang Efektif');
            $table->text('catatan');
            $table->string('foto_sebelum')->nullable();
            $table->string('foto_sesudah')->nullable();
            $table->text('foto_ai_raw')->nullable()->comment('Raw JSON analisis AI perbandingan foto');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluasis');
    }
};
