<div class="p-6 relative" x-data="labStatusManager()" x-init="init()">
    <!-- Hidden inputs untuk mendapatkan flash session dari controller -->
    <input type="hidden" id="showPendingFlag" value="{{ session('showPendingModal') ? '1' : '0' }}">
    <input type="hidden" id="bookingResult" value="{{ session('booking_result') ?? '' }}">

    <table class="table-auto w-full text-white border-collapse">
        <thead class="bg-gray-800">
            <tr>
                <th class="px-4 py-2 text-center">Ruang</th>
                <th class="px-4 py-2 text-center">Jam</th>
                <th class="px-4 py-2 text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laboratories as $lab)
                @php
                    // Ambil booking terbaru (jika ada) untuk lab ini
                    $booking = $lab->bookings()->latest()->first();
                @endphp
                <tr>
                    <td class="px-4 py-2 bg-gray-900 border-b border-gray-700 text-center align-middle">
                        {{ $lab->lab_name }}
                    </td>
                    <td class="px-4 py-2 bg-gray-800 border-b border-gray-700 text-center align-middle">
                        {{ $lab->schedule }}
                    </td>
                    <td class="px-4 py-2 bg-gray-900 border-b border-gray-700 text-center align-middle">
                        @if($lab->is_available)
                            <!-- Jika lab available, tampilkan tombol Available -->
                            <button
                                class="bg-yellow-500 text-black px-3 py-1 rounded"
                                @click="
                                    showBorrowModal = true;
                                    selectedLabId = {{ $lab->id }};
                                    selectedLabSchedule = '{{ $lab->schedule }}'
                                "
                            >
                                Available
                            </button>
                        @else
                            <!-- Jika lab tidak available, tampilkan status booking terakhir -->
                            @if($booking && $booking->response_admin == null)
                                <span class="bg-blue-500 text-white px-3 py-1 rounded">Pending</span>
                            @elseif($booking && $booking->response_admin == 1)
                                @if(Auth::check() && Auth::user()->role == 0)
                                    <!-- Jika admin login, span klikabel untuk restore -->
                                    <span
                                        class="cursor-pointer bg-gray-500 text-white px-3 py-1 rounded"
                                        @click="openRestoreModal({{ $lab->id }}, '{{ $lab->schedule }}')"
                                    >
                                        Booked
                                    </span>
                                @else
                                    <span class="bg-gray-500 text-white px-3 py-1 rounded">Booked</span>
                                @endif
                            @else
                                <span class="bg-red-500 text-white px-3 py-1 rounded">Rejected</span>
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal Form Peminjaman (untuk user) -->
    <div 
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
        x-show="showBorrowModal"
        x-transition
    >
        <div 
            class="bg-gray-800 text-white p-6 rounded-lg w-96 relative" 
            @click.away="showBorrowModal = false" 
            @click.stop
        >
            <h3 class="text-xl font-bold mb-4 text-yellow-400">Form Peminjaman Lab</h3>
            <form action="{{ route('bookings.store') }}" method="POST" class="space-y-4" @submit="showBorrowModal = false">
                @csrf
                <input type="hidden" name="laboratory_id" x-model="selectedLabId">
                <input type="hidden" name="schedule" x-model="selectedLabSchedule">
                <div>
                    <label for="purpose" class="block mb-1 text-white">Keperluan</label>
                    <textarea id="purpose" name="purpose" class="w-full px-3 py-2 rounded bg-gray-700 text-white focus:outline-none" placeholder="Tuliskan keperluan" required></textarea>
                </div>
                <div>
                    <label for="lecture_name" class="block mb-1 text-white">Nama Dosen</label>
                    <input type="text" id="lecture_name" name="lecture_name" class="w-full px-3 py-2 rounded bg-gray-700 text-white focus:outline-none" placeholder="Masukkan nama dosen" required>
                </div>
                <button type="submit" class="bg-yellow-500 text-black px-4 py-2 rounded font-semibold w-full">
                    Ajukan
                </button>
            </form>
            <button class="absolute top-2 right-2 text-gray-400 hover:text-white" @click="showBorrowModal = false">&times;</button>
        </div>
    </div>

    <!-- Modal "Menunggu Persetujuan Admin" (untuk user) -->
    <template x-if="showPendingModal">
        <div 
            class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
            x-transition
        >
            <div class="bg-gray-800 w-96 p-6 rounded-lg shadow-lg text-center">
                <h3 class="text-xl font-bold mb-4 text-blue-400">Menunggu Balasan Admin</h3>
                <p class="text-white">Permintaan peminjaman Anda sedang diproses oleh admin.</p>
            </div>
        </div>
    </template>

    <!-- Modal Hasil Booking (Accepted/Rejected) untuk user -->
    <template x-if="bookingResult !== ''">
        <div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50" x-transition>
            <div class="bg-gray-800 w-96 p-6 rounded-lg shadow-lg text-center">
                <template x-if="bookingResult === 'accepted'">
                    <div>
                        <h3 class="text-xl font-bold mb-4 text-green-500">Peminjaman Diterima</h3>
                        <p class="text-white">Peminjaman Anda diterima. Silakan gunakan laboratorium sesuai jadwal.</p>
                    </div>
                </template>
                <template x-if="bookingResult === 'rejected'">
                    <div>
                        <h3 class="text-xl font-bold mb-4 text-red-500">Peminjaman Ditolak</h3>
                        <p class="text-white">Peminjaman Anda ditolak. Silakan coba kembali atau hubungi admin.</p>
                    </div>
                </template>
                <button class="mt-4 bg-gray-500 text-white px-4 py-2 rounded font-semibold w-full" @click="clearBookingResult()">OK</button>
            </div>
        </div>
    </template>

    <!-- Modal Restore: Untuk Admin mengembalikan status lab menjadi Available -->
    <div 
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
        x-show="showRestoreModal"
        x-transition
    >
        <div class="bg-gray-800 text-white p-6 rounded-lg w-96 relative" @click.away="closeRestoreModal()" @click.stop>
            <h3 class="text-xl font-bold mb-4">Konfirmasi Pengembalian Lab</h3>
            <p class="mb-4">Apakah Anda yakin ingin mengembalikan status lab ini menjadi Available?</p>
            <form action="{{ route('bookings.restore') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="laboratory_id" :value="restoreLabId">
                <button type="submit" class="bg-green-500 text-black px-4 py-2 rounded font-semibold w-full">Konfirmasi</button>
            </form>
            <button class="absolute top-2 right-2 text-gray-400 hover:text-white" @click="closeRestoreModal()">✕</button>
        </div>
    </div>
</div>


    @if(session('toast'))
        <div 
            class="fixed bottom-4 right-4 bg-{{ session('toast.type') === 'success' ? 'green' : 'red' }}-500 text-white px-6 py-3 rounded shadow-lg z-50 transition"
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 3000)"
            x-show="show"
            x-transition
        >
            {{ session('toast.message') }}
        </div>
    @endif

<script>
    function labStatusManager() {
        return {
            // State untuk modals
            showBorrowModal: false,    // Modal form peminjaman (user)
            showPendingModal: false,   // Modal "Menunggu Balasan Admin" (user)
            showRestoreModal: false,   // Modal untuk restore lab (admin)
            bookingResult: '',         // Hasil booking, misalnya 'accepted' atau 'rejected' (user)

            // Selected lab state
            selectedLabId: null,
            selectedLabSchedule: '',
            restoreLabId: null,

            // Inisialisasi berdasarkan flash session
            init() {
                const showPendingFlag = document.getElementById('showPendingFlag')?.value;
                if (showPendingFlag === '1') {
                    this.showPendingModal = true;
                }
                const result = document.getElementById('bookingResult')?.value;
                if(result !== '') {
                    this.bookingResult = result;
                }
            },

            // Method untuk meng-clear booking result modal
            clearBookingResult() {
                this.bookingResult = '';
            },

            // Modal restore untuk admin
            openRestoreModal(labId, schedule) {
                this.restoreLabId = labId;
                this.selectedLabSchedule = schedule;
                this.showRestoreModal = true;
            },
            closeRestoreModal() {
                this.showRestoreModal = false;
            }
        };
    }
</script>
