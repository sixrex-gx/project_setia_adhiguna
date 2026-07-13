<?php

namespace Tests\Feature;

use App\Models\Penggajian;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PenggajianFeatureTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_stores_penggajian_with_correct_net_salary(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $kasir = User::factory()->create(['role' => 'kasir']);

        $response = $this->actingAs($admin)->post(route('penggajian.store', $kasir->id), [
            'periode'       => '2026-07',
            'gaji_pokok'    => 2500000,
            'tunjangan'     => 500000,
            'lembur_jam'    => 10,
            'lembur_rate'   => 25000,
            'potongan'      => 100000,
            'tanggal_bayar' => '2026-07-31',
        ]);

        $response->assertRedirect(route('penggajian.index', $kasir->id));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('penggajians', [
            'user_id'      => $kasir->id,
            'periode'      => '2026-07',
            'gaji_pokok'   => 2500000,
            'tunjangan'    => 500000,
            'lembur_jam'   => 10,
            'lembur_rate'  => 25000,
            'potongan'     => 100000,
            'gaji_bersih'  => 2500000 + 500000 + (10 * 25000) - 100000,
            'tanggal_bayar' => '2026-07-31',
        ]);
    }

    #[Test]
    public function it_only_allows_kasir_users_for_penggajian(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $userAdmin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post(route('penggajian.store', $userAdmin->id), [
            'periode'       => '2026-07',
            'gaji_pokok'    => 2500000,
            'tunjangan'     => 0,
            'lembur_jam'    => 0,
            'lembur_rate'   => 0,
            'potongan'      => 0,
        ]);

        $response->assertSessionHasErrors(['user_id']);
        $this->assertDatabaseCount('penggajians', 0);
    }
}
