<?php

namespace App\Http\Controllers;

use App\Models\Penggajian;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class PenggajianController extends Controller
{
    public function index(User $user, Request $request)
    {
        $penggajians = Penggajian::where('user_id', $user->id)->latest()->get();
        $periodes = $penggajians->pluck('periode')->unique()->sortDesc()->values();

        $selectedPeriode = $request->get('periode', $periodes->first());
        $detailGaji = $penggajians->firstWhere('periode', $selectedPeriode);

        $now = \Carbon\Carbon::now('Asia/Jakarta');
        $startOfWeek = $now->copy()->startOfWeek();
        $endOfWeek   = $now->copy()->endOfWeek();

        $todayStart = $now->copy()->startOfDay();
        $todayEnd   = $now->copy()->endOfDay();

        $trxToday = Transaction::where('user_id', $user->id)
            ->whereBetween('created_at', [$todayStart, $todayEnd])
            ->where('status', 'Lunas')
            ->count();

        $statusLabel = $trxToday > 0 ? 'Aktif' : 'Belum Mulai';
        $statusClass = $trxToday > 0 ? 'success' : 'warn';

        $dailyTransactions = Transaction::where('user_id', $user->id)
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->where('status', 'Lunas')
            ->selectRaw('DATE(created_at) as trx_date, COUNT(*) as total_trx, SUM(total) as total_omzet')
            ->groupByRaw('DATE(created_at)')
            ->get()
            ->keyBy('trx_date');

        $hariIndo = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        $absensi = [];
        $totalTrxWeek = 0;
        $totalOmzetWeek = 0;
        $hariMasuk = 0;

        for ($i = 0; $i < 7; $i++) {
            $date = $startOfWeek->copy()->addDays($i);
            $dateStr = $date->format('Y-m-d');
            $dayData = $dailyTransactions->get($dateStr);

            $trxCount = $dayData ? (int) $dayData->total_trx : 0;
            $omzet = $dayData ? (float) $dayData->total_omzet : 0;

            $totalTrxWeek += $trxCount;
            $totalOmzetWeek += $omzet;
            if ($trxCount > 0) $hariMasuk++;

            $absensi[] = [
                'hari'    => $hariIndo[$date->dayOfWeek],
                'tanggal' => $date->format('d M'),
                'status'  => $trxCount > 0 ? 'Masuk' : 'Libur',
                'trx'     => $trxCount,
                'omzet'   => $omzet,
            ];
        }

        return view('penggajian.index', compact(
            'user', 'penggajians', 'periodes', 'selectedPeriode', 'detailGaji',
            'absensi', 'totalTrxWeek', 'totalOmzetWeek', 'hariMasuk',
            'trxToday', 'statusLabel', 'statusClass'
        ));
    }

    public function create(User $user)
    {
        return view('penggajian.create', compact('user'));
    }

    public function store(Request $request, User $user)
    {
        if ($user->role !== 'kasir') {
            return back()->withErrors(['user_id' => 'User harus berperan sebagai kasir.'])->withInput();
        }

        $validated = $request->validate([
            'periode'       => 'required|string|max:7',
            'gaji_pokok'    => 'required|numeric|min:0',
            'tunjangan'     => 'nullable|numeric|min:0',
            'lembur_jam'    => 'nullable|numeric|min:0',
            'lembur_rate'   => 'nullable|numeric|min:0',
            'potongan'      => 'nullable|numeric|min:0',
            'tanggal_bayar' => 'nullable|date',
        ]);

        $gajiPokok   = (float) ($validated['gaji_pokok'] ?? 0);
        $tunjangan   = (float) ($validated['tunjangan'] ?? 0);
        $lemburJam   = (float) ($validated['lembur_jam'] ?? 0);
        $lemburRate  = (float) ($validated['lembur_rate'] ?? 0);
        $potongan    = (float) ($validated['potongan'] ?? 0);

        $gajiBersih = Penggajian::hitungGajiBersih($gajiPokok, $tunjangan, $lemburJam, $lemburRate, $potongan);

        Penggajian::create([
            'user_id'       => $user->id,
            'periode'       => $validated['periode'],
            'gaji_pokok'    => $gajiPokok,
            'tunjangan'     => $tunjangan,
            'lembur_jam'    => $lemburJam,
            'lembur_rate'   => $lemburRate,
            'potongan'      => $potongan,
            'gaji_bersih'   => $gajiBersih,
            'tanggal_bayar' => $validated['tanggal_bayar'] ?? null,
        ]);

        return redirect()->route('penggajian.index', $user->id)
            ->with('success', 'Data penggajian berhasil disimpan.');
    }

    public function bayar(User $user, Penggajian $penggajian)
    {
        if ($penggajian->user_id !== $user->id) {
            abort(404);
        }

        $penggajian->update([
            'tanggal_bayar' => now('Asia/Jakarta')->toDateString(),
        ]);

        return redirect()->route('penggajian.index', [$user->id, 'periode' => $penggajian->periode])
            ->with('success', 'Pembayaran gaji periode ' . $penggajian->periode . ' berhasil dicatat.');
    }
}
