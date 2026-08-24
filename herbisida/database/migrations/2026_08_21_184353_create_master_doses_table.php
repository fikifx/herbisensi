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
        Schema::create('master_doses', function (Blueprint $table) {
            $table->id();
            $table->string('item_pekerjaan')->nullable();
            $table->string('jenis_gulma')->nullable();
            $table->string('material_1')->nullable();
            $table->string('material_2')->nullable();
            $table->string('material_3')->nullable();
            $table->decimal('dosis_1', 10, 4)->nullable();
            $table->decimal('dosis_2', 10, 4)->nullable();
            $table->decimal('dosis_3', 10, 4)->nullable();
            $table->decimal('volume_1', 10, 4)->nullable();
            $table->decimal('volume_2', 10, 4)->nullable();
            $table->decimal('volume_3', 10, 4)->nullable();
            $table->decimal('kapasitas_intersprayer', 10, 4)->nullable();
            $table->decimal('jumlah_intersprayer', 10, 4)->nullable();
            $table->decimal('herb_kap_1', 10, 4)->nullable();
            $table->decimal('herb_kap_2', 10, 4)->nullable();
            $table->decimal('herb_kap_3', 10, 4)->nullable();
            $table->decimal('herb_ltr_1', 10, 4)->nullable();
            $table->decimal('herb_ltr_2', 10, 4)->nullable();
            $table->decimal('herb_ltr_3', 10, 4)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_doses');
    }
};
