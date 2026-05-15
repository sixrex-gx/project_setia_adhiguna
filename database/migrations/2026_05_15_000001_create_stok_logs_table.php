<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stok_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('produk_id')->constrained('products')->cascadeOnDelete();
            $table->enum('tipe', ['masuk', 'keluar']);
            $table->integer('qty');
            $table->bigInteger('nilai');
            $table->string('referensi_tipe');
            $table->unsignedBigInteger('referensi_id')->nullable();
            $table->string('keterangan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stok_logs');
    }
};
