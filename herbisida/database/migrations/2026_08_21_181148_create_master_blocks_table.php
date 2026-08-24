<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('master_blocks', function (Blueprint $table) {
            $table->id();
            $table->string('block_code', 20)->unique();
            $table->decimal('luas_tanam', 8, 2)->nullable();
            $table->integer('tahun_tanam')->nullable();
            $table->integer('jumlah_pokok')->nullable();
            $table->string('topografi', 50)->nullable();
            $table->integer('umur_tanam')->nullable();
            $table->string('kategori_umur', 50)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_blocks');
    }
};
