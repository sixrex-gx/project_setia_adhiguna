<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        DB::table('settings')->insert([
            ['key' => 'ppn', 'value' => '11'],
            ['key' => 'qris_fee', 'value' => '0.7'],
            ['key' => 'store_name', 'value' => 'TokoAdv — ATK & Advertising'],
            ['key' => 'store_address', 'value' => 'Senen Jaya Blok 1&2 Lt.2 No.A7-15 Senen, Jakarta Pusat'],
            ['key' => 'store_phone', 'value' => '0813 8232 8476'],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
