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
        Schema::create('master_gulmas', function (Blueprint $table) {
            $table->id();
            $table->integer('sampel')->nullable();
            $table->string('nama_gulma')->nullable();
            $table->decimal('jumlah', 8, 2)->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_gulmas');
    }
};
