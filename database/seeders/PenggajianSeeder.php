<?php

namespace Database\Seeders;

use App\Models\Penggajian;
use App\Models\User;
use Illuminate\Database\Seeder;

class PenggajianSeeder extends Seeder
{
    public function run(): void
    {
        $kasirs = User::where('role', 'kasir')->get();

        if ($kasirs->isEmpty()) {
            $kasirs = collect();
            $kasirs->push(User::create([
                'name'     => 'Budi Santoso',
                'email'    => 'kasir@tokoadv.id',
                'password' => bcrypt('kasir123'),
                'role'     => 'kasir',
            ]));
        }

        $kasir1 = $kasirs->get(0);
        $kasir2 = $kasirs->get(1) ?? $kasir1;

        $data = [
            // Budi Santoso — 3 periode
            [
                'user_id'      => $kasir1->id,
                'periode'      => '2026-05',
                'gaji_pokok'   => 2500000,
                'tunjangan'    => 250000,
                'lembur_jam'   => 5,
                'lembur_rate'  => 25000,
                'potongan'     => 75000,
                'gaji_bersih'  => 0,
                'tanggal_bayar' => '2026-05-31',
            ],
            [
                'user_id'      => $kasir1->id,
                'periode'      => '2026-06',
                'gaji_pokok'   => 2500000,
                'tunjangan'    => 500000,
                'lembur_jam'   => 10,
                'lembur_rate'  => 25000,
                'potongan'     => 100000,
                'gaji_bersih'  => 0,
                'tanggal_bayar' => '2026-06-30',
            ],
            [
                'user_id'      => $kasir1->id,
                'periode'      => '2026-07',
                'gaji_pokok'   => 2500000,
                'tunjangan'    => 500000,
                'lembur_jam'   => 8,
                'lembur_rate'  => 25000,
                'potongan'     => 0,
                'gaji_bersih'  => 0,
                'tanggal_bayar' => '2026-07-31',
            ],
            // Siti Rahmawati — 2 periode
            [
                'user_id'      => $kasir2->id,
                'periode'      => '2026-06',
                'gaji_pokok'   => 3000000,
                'tunjangan'    => 750000,
                'lembur_jam'   => 12,
                'lembur_rate'  => 30000,
                'potongan'     => 150000,
                'gaji_bersih'  => 0,
                'tanggal_bayar' => null,
            ],
            [
                'user_id'      => $kasir2->id,
                'periode'      => '2026-07',
                'gaji_pokok'   => 2800000,
                'tunjangan'    => 400000,
                'lembur_jam'   => 0,
                'lembur_rate'  => 0,
                'potongan'     => 50000,
                'gaji_bersih'  => 0,
                'tanggal_bayar' => '2026-07-31',
            ],
        ];

        foreach ($data as $item) {
            $item['gaji_bersih'] = Penggajian::hitungGajiBersih(
                $item['gaji_pokok'],
                $item['tunjangan'],
                $item['lembur_jam'],
                $item['lembur_rate'],
                $item['potongan'],
            );

            Penggajian::create($item);
        }
    }
}
