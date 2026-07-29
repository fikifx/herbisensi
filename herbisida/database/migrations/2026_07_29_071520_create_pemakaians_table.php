<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemakaians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('block_id')->constrained('blocks')->onDelete('cascade');
            $table->integer('jerigen')->comment('Volume dalam liter');
            $table->string('batch', 20)->comment('Nomor batch material');
            $table->datetime('waktu')->comment('Waktu scan/input');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemakaians');
    }
};
