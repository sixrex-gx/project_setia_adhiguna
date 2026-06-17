<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key');
        return response()->json($settings);
    }

    public function update(Request $request)
    {
        $request->validate([
            'ppn'          => 'required|numeric|min:0|max:100',
            'qris_fee'     => 'required|numeric|min:0|max:100',
            'store_name'   => 'nullable|string|max:255',
            'store_address' => 'nullable|string',
            'store_phone'  => 'nullable|string|max:50',
        ]);

        foreach (['ppn', 'qris_fee', 'store_name', 'store_address', 'store_phone'] as $key) {
            if ($request->has($key)) {
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $request->$key]
                );
            }
        }

        return response()->json(['message' => 'Pengaturan berhasil disimpan']);
    }
}
