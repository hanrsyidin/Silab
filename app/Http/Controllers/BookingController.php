<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Laboratory;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{

    // public function index()
    // {
    //     // Ambil data booking yang disetujui untuk contoh modal (optional)
    //     $customData = Booking::with('user', 'laboratory')->latest()->first();

    //     // Render view admin dan lempar data ke komponen
    //     return view('admin', compact('customData'));
    // }

    // Menyimpan pengajuan peminjaman laboratorium
    public function store(Request $request)
    {
        $request->validate([
            'purpose' => 'required|string|max:255',
            'lecture_name' => 'required|string|max:255',
            'laboratory_id' => 'required|exists:laboratories,id',
            'schedule' => 'required|string',
        ]);

        $user = Auth::user();
        $laboratory = Laboratory::findOrFail($request->laboratory_id);

        // Cek apakah laboratorium masih tersedia
        if (!$laboratory->is_available) {
            return redirect()->back()->with('error', 'Laboratorium sudah dipinjam oleh orang lain.');
        }

        // Simpan peminjaman
        Booking::create([
            'user_id' => $user->id,
            'laboratory_id' => $laboratory->id,
            'purpose' => $request->purpose,
            'lecture_name' => $request->lecture_name,
            'schedule' => $laboratory->schedule,
            'booking_time' => now(),
            'response_admin' => null, // Menunggu balasan admin
        ]);

        // Ubah status laboratorium menjadi tidak tersedia
        $laboratory->update(['is_available' => false]);

        return redirect()->back()->with('success', 'Peminjaman berhasil diajukan. Menunggu balasan admin.');
    }
    
    // Mengembalikan laboratorium menjadi tersedia (jika sudah selesai digunakan)
    public function restoreAvailability(Request $request)
    {
        $request->validate([
            'laboratory_id' => 'required|exists:laboratories,id',
        ]);

        $laboratory = Laboratory::findOrFail($request->laboratory_id);

        // Periksa apakah ada peminjaman yang masih aktif untuk lab ini
        $activeBooking = Booking::where('laboratory_id', $laboratory->id)
                                ->where('response_admin', 1)
                                ->exists();

        if (!$activeBooking) {
            return redirect()->back()->with('error', 'Tidak ada peminjaman aktif untuk laboratorium ini.');
        }

        // Ubah status lab menjadi available kembali
        $laboratory->update(['is_available' => true]);

        return redirect()->back()->with('success', 'Laboratorium berhasil dikembalikan sebagai tersedia.');
    }

    public function accept($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->response_admin = 1; // Diterima
        $booking->save();
    
        return redirect()->back()->with('success', 'Peminjaman diterima.');
    }
    
    public function reject($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->response_admin = 0; // Ditolak
        $booking->save();
    
        return redirect()->back()->with('error', 'Peminjaman ditolak.');
    }
    
}
