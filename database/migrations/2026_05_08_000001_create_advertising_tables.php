<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── STEP 1: Tambah kolom ke tabel transactions ──
        Schema::table('transactions', function (Blueprint $table) {
            if (!Schema::hasColumn('transactions', 'order_type')) {
                $table->enum('order_type', ['atk', 'advertising'])->default('atk')->after('id');
            }
            if (!Schema::hasColumn('transactions', 'production_status')) {
                $table->enum('production_status', [
                    'Pending', 'Design', 'Cetak', 'Selesai', 'Diambil'
                ])->default('Pending')->after('order_type');
            }
            if (!Schema::hasColumn('transactions', 'production_notes')) {
                $table->text('production_notes')->nullable()->after('production_status');
            }
            if (!Schema::hasColumn('transactions', 'customer_phone')) {
                $table->string('customer_phone', 20)->nullable()->after('customer');
            }
        });

        // ── STEP 2: Buat tabel detail item advertising ──
        Schema::create('advertising_order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_id')->constrained('transactions')->onDelete('cascade');
            $table->string('item_name');
            $table->decimal('panjang', 8, 2);
            $table->decimal('lebar', 8, 2);
            $table->decimal('luas_total', 10, 4);
            $table->decimal('harga_per_meter', 12, 2);
            $table->string('material_name')->nullable();
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('subtotal', 14, 2);
            $table->json('finishing')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('advertising_order_details');

        Schema::table('transactions', function (Blueprint $table) {
            $cols = ['order_type', 'production_status', 'production_notes', 'customer_phone'];
            foreach ($cols as $col) {
                if (Schema::hasColumn('transactions', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};