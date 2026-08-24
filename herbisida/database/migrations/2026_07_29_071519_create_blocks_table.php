<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blocks', function (Blueprint $table) {
            $table->id();
            $table->string('block_code', 10)->unique();
            $table->enum('afdeling', ['OF', 'OB', 'OH', 'OD'])->default('OF');
            $table->decimal('luas', 8, 2)->comment('Luas dalam Ha');
            $table->string('gulma')->comment('Jenis gulma dominan');
            $table->string('gulma_foto')->nullable()->comment('Path foto gulma yang di-upload');
            $table->text('gulma_ai_raw')->nullable()->comment('Raw JSON response dari Gemini AI');
            $table->integer('kerapatan')->default(0)->comment('Angka kerapatan');
            $table->string('herbisida')->comment('Nama herbisida rekomendasi');
            $table->decimal('dosis', 5, 2)->comment('Dosis L/Ha');
            $table->integer('rekomendasi')->comment('Total liter = luas x dosis');
            $table->integer('aktual')->default(0)->comment('Total pemakaian aktual dalam liter');
            $table->enum('status', ['Belum Selesai', 'Selesai'])->default('Belum Selesai');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blocks');
    }
};
