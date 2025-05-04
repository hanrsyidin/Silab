<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Laboratory;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // Menyimpan pengajuan peminjaman laboratorium
    public function store(Request $request)
    {
        $request->validate([
            'purpose'       => 'required|string|max:255',
            'lecture_name'  => 'required|string|max:255',
            'laboratory_id' => 'required|exists:laboratories,id',
            'schedule'      => 'required|string',
        ]);

        $user = Auth::user();
        $laboratory = Laboratory::findOrFail($request->laboratory_id);

        // Cek apakah laboratorium masih available
        if (!$laboratory->is_available) {
            return redirect()->back()->with('error', 'Laboratorium sudah dipinjam oleh orang lain.');
        }

        // Simpan peminjaman dengan status pending (response_admin null)
        Booking::create([
            'user_id'        => $user->id,
            'laboratory_id'  => $laboratory->id,
            'purpose'        => $request->purpose,
            'lecture_name'   => $request->lecture_name,
            'schedule'       => $laboratory->schedule,
            'booking_time'   => now(),
            'response_admin' => null, // Menunggu balasan admin
        ]);

        // Ubah status laboratorium menjadi tidak tersedia
        $laboratory->update(['is_available' => false]);

        // Flash session untuk menampilkan modal "Menunggu Balasan Admin" di view (opsional)
        session()->flash('showPendingModal', true);

        return redirect()->route('dashboard')
                         ->with('success', 'Peminjaman berhasil diajukan. Menunggu balasan admin.');
    }
    
    // Mengembalikan laboratorium menjadi tersedia (jika sudah selesai digunakan)
    public function restoreAvailability(Request $request)
    {
        $request->validate([
            'laboratory_id' => 'required|exists:laboratories,id',
        ]);

        $laboratory = Laboratory::findOrFail($request->laboratory_id);

        // Periksa apakah ada peminjaman aktif untuk lab ini yang sudah disetujui (response_admin == 1)
        $activeBooking = Booking::where('laboratory_id', $laboratory->id)
                                ->where('response_admin', 1)
                                ->exists();

        if (!$activeBooking) {
            return redirect()->back()->with('error', 'Tidak ada peminjaman aktif untuk laboratorium ini.');
        }

        // Ubah status laboratorium menjadi available kembali
        $laboratory->update(['is_available' => true]);

        return redirect()->back()->with('success', 'Laboratorium berhasil dikembalikan sebagai tersedia.');
    }

    // Admin menyetujui peminjaman
    public function accept($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->response_admin = 1; // Diterima
        $booking->save();
    
        return back(); // atau redirect()->back(); jika ingin tetap kembali ke halaman sebelumnya
    }
    
    // Admin menolak peminjaman
    public function reject($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->response_admin = 0; // Ditolak
        $booking->save();
    
        // Kembalikan status laboratorium menjadi available
        $laboratory = Laboratory::findOrFail($booking->laboratory_id);
        $laboratory->update(['is_available' => true]);
    
        return back(); // tanpa flash message
    }
}
