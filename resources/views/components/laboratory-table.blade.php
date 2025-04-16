@php
    $groupedLabs = $laboratories->groupBy('lab_name');
@endphp

<div class="p-6" x-data="labStatusManager()" x-init="init()">
    <input type="hidden" id="showPendingFlag" value="{{ session('showPendingModal') ? '1' : '0' }}">
    <table class="table-auto w-full text-white border-collapse">
        <thead class="bg-gray-800">
            <tr>
                <th class="px-4 py-2 text-center">Ruang</th>
                <th class="px-4 py-2 text-center">Jam</th>
                <th class="px-4 py-2 text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($groupedLabs as $labName => $labs)
                @foreach($labs as $index => $lab)
                    @php
                        $booking = $lab->bookings()->latest()->first();
                    @endphp
        
                    <tr>
                        {{-- RUANG - hanya ditampilkan sekali per grup --}}
                        @if($index === 0)
                            <td class="px-4 py-2 bg-gray-900 border-b border-gray-700 text-center align-middle" rowspan="{{ $labs->count() }}">
                                {{ $labName }}
                            </td>
                        @endif
        
                        {{-- JAM --}}
                        <td class="px-4 py-2 bg-gray-800 border-b border-gray-700 text-center align-middle">
                            {{ $lab->schedule }}
                        </td>
        
                        {{-- STATUS --}}
                        <td class="px-4 py-2 bg-gray-900 border-b border-gray-700 text-center align-middle">
                            <template x-if="pendingLabs[{{ $lab->id }}]">
                                <span class="bg-blue-500 text-white px-3 py-1 rounded">Pending</span>
                            </template>
        
                            <template x-if="!pendingLabs[{{ $lab->id }}]">
                                @if($lab->is_available)
                                    <button
                                        class="bg-yellow-500 text-black px-3 py-1 rounded"
                                        @click="showBorrowModal = true; selectedLabId = {{ $lab->id }}; selectedLabSchedule = '{{ $lab->schedule }}'"
                                    >
                                        Available
                                    </button>
                                @else
                                    @if($booking && $booking->response_admin === null)
                                        <span class="bg-blue-500 text-white px-3 py-1 rounded">Pending</span>
                                    @elseif($booking && $booking->response_admin === 1)
                                        <span class="bg-green-500 text-white px-3 py-1 rounded">Approved</span>
                                    @else
                                        <span class="bg-red-500 text-white px-3 py-1 rounded">Rejected</span>
                                    @endif
                                @endif
                            </template>
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    {{-- Modal Form Peminjaman --}}
    <div 
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
        x-show="showBorrowModal"
        x-transition
    >
        <div class="bg-gray-800 w-96 p-6 rounded-lg shadow-lg relative" @click.away="showBorrowModal = false" @click.stop>
            <h3 class="text-xl font-bold mb-4 text-yellow-400">Form Peminjaman Lab</h3>

            <form action="{{ route('bookings.store') }}" method="POST" class="space-y-4" 
                @submit="showPendingModal = true; showBorrowModal = false; setPending(selectedLabId)">
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

    {{-- Modal Menunggu Persetujuan --}}
    <div 
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
        x-show="showPendingModal"
        x-transition
    >
        <div class="bg-gray-800 w-96 p-6 rounded-lg shadow-lg text-center">
            <h3 class="text-xl font-bold mb-4 text-blue-400">Menunggu Balasan Admin</h3>
            <p class="text-white">Permintaan peminjaman Anda sedang diproses oleh admin.</p>
        </div>
    </div>
</div>

<script>
    function labStatusManager() {
        return {
            showBorrowModal: false,
            showPendingModal: false,
            selectedLabId: null,
            selectedLabSchedule: '',
            pendingLabs: {},

            setPending(labId) {
                this.pendingLabs[labId] = true;
            },

            init() {
                const showPendingFlag = document.getElementById('showPendingFlag')?.value;
                if (showPendingFlag === '1') {
                    this.showPendingModal = true;
                }
            }
        };
    }
</script>