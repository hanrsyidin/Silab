{{-- List Booking --}}
<div>
@foreach($bookings as $booking)
    <div class="bg-gray-700 text-white px-4 py-4 rounded mb-4 shadow">
        <div class="font-semibold text-lg mb-2">
            👤 {{ $booking->user->name }}
        </div>

        <div class="space-y-1 text-sm">
            <p><strong>Ruang:</strong> {{ $booking->laboratory->lab_name }}</p>
            <p><strong>Jadwal:</strong> {{ $booking->schedule }}</p>
            <p><strong>Nama Dosen:</strong> {{ $booking->lecture_name }}</p>
            <p><strong>Keperluan:</strong> {{ $booking->purpose }}</p>
        </div>

        <div class="mt-4 flex gap-2">
            {{-- Tombol Terima --}}
            <form method="POST" action="{{ url('/admin/dashboard/' . $booking->id . '/accept') }}">
                @csrf
                <button type="submit" class="bg-yellow-400 px-4 py-2 rounded text-black hover:bg-yellow-300">
                    Terima
                </button>
            </form>

            {{-- Tombol Tolak --}}
            <form method="POST" action="{{ url('/admin/dashboard/' . $booking->id . '/reject') }}">
                @csrf
                <button type="submit" class="bg-red-600 px-4 py-2 rounded text-white hover:bg-red-500">
                    Tolak
                </button>
            </form>
        </div>
    </div>
@endforeach
</div>