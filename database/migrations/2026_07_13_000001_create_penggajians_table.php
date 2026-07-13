<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penggajians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('periode', 7);
            $table->decimal('gaji_pokok', 12, 2);
            $table->decimal('tunjangan', 12, 2)->default(0);
            $table->decimal('lembur_jam', 5, 2)->default(0);
            $table->decimal('lembur_rate', 12, 2)->default(0);
            $table->decimal('potongan', 12, 2)->default(0);
            $table->decimal('gaji_bersih', 12, 2);
            $table->date('tanggal_bayar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penggajians');
    }
};
