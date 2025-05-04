<div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">
        Riwayat Peminjaman
    </h2>

    <div class="overflow-x-auto">
        <table class="min-w-full table-auto text-gray-800 dark:text-gray-200">
            <thead class="bg-gray-200 dark:bg-gray-700">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Nama Mahasiswa</th>
                    <th class="px-4 py-2">Laboratorium</th>
                    <th class="px-4 py-2">Keperluan</th>
                    <th class="px-4 py-2">Nama Dosen</th>
                    <th class="px-4 py-2">Jadwal</th>
                    <th class="px-4 py-2">Waktu Booking</th>
                    <th class="px-4 py-2">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $b)
                    <tr class="border-b border-gray-300 dark:border-gray-600">
                        <td class="px-4 py-2">{{ $b->id }}</td>
                        <td class="px-4 py-2">{{ $b->user->name }}</td>
                        <td class="px-4 py-2">{{ $b->laboratory->lab_name }}</td>
                        <td class="px-4 py-2">{{ $b->purpose }}</td>
                        <td class="px-4 py-2">{{ $b->lecture_name }}</td>
                        <td class="px-4 py-2">{{ $b->schedule }}</td>
                        <td class="px-4 py-2">{{ $b->booking_time }}</td>
                        <td class="px-4 py-2">
                            @if(is_null($b->response_admin))
                                <span class="px-2 py-1 bg-blue-500 text-white rounded">Pending</span>
                            @elseif($b->response_admin == 1)
                                <span class="px-2 py-1 bg-green-500 text-white rounded">Approved</span>
                            @else
                                <span class="px-2 py-1 bg-red-500 text-white rounded">Rejected</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-4 py-2 text-center" colspan="8">Belum ada riwayat peminjaman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
