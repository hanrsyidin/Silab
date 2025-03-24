{{-- resources/views/laboratory/index.blade.php --}}

<div class="p-6" x-data="{ openModal: false }">
    <table class="table-auto w-full text-white border-collapse">
        <thead class="bg-gray-800">
            <tr>
                <th class="px-4 py-2 text-center">Ruang</th>
                <th class="px-4 py-2 text-center">Jam</th>
                <th class="px-4 py-2 text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laboratories as $lab)
                <tr>
                    <td class="px-4 py-2 bg-gray-900 border-b border-gray-700 text-center align-middle">
                        {{ $lab->lab_name }}
                    </td>
                    <td class="px-4 py-2 bg-gray-800 border-b border-gray-700 text-center align-middle">
                        {{ $lab->schedule }}
                    </td>
                    <td class="px-4 py-2 bg-gray-900 border-b border-gray-700 text-center align-middle">
                        @if($lab->is_available)
                            {{-- Tombol untuk membuka modal --}}
                            <button
                                class="bg-yellow-500 text-black px-3 py-1 rounded"
                                @click="openModal = true"
                            >
                                Available
                            </button>
                        @else
                            <button class="bg-gray-500 text-white px-3 py-1 rounded">
                                Booked
                            </button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Bagian Modal --}}
    <div
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
        x-show="openModal"
        x-transition
    >
        <div
            class="bg-gray-800 w-96 p-6 rounded-lg shadow-lg relative"
            @click.away="openModal = false"
        >
            <h3 class="text-xl font-bold mb-4 text-yellow-400">Form Peminjaman Lab</h3>

            {{-- Formulir Peminjaman (sesuaikan action method) --}}
            <form action="#" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="nama" class="block mb-1 text-white">Nama Peminjam</label>
                    <input
                        type="text"
                        id="nama"
                        name="nama"
                        class="w-full px-3 py-2 rounded bg-gray-700 text-white focus:outline-none"
                        placeholder="Masukkan nama"
                    >
                </div>
                <div>
                    <label for="keperluan" class="block mb-1 text-white">Keperluan</label>
                    <textarea
                        id="keperluan"
                        name="keperluan"
                        class="w-full px-3 py-2 rounded bg-gray-700 text-white focus:outline-none"
                        placeholder="Tuliskan keperluan"
                    ></textarea>
                </div>
                <button
                    type="submit"
                    class="bg-yellow-500 text-black px-4 py-2 rounded font-semibold w-full"
                >
                    Ajukan
                </button>
            </form>

            {{-- Tombol Close di pojok kanan atas (opsional) --}}
            <button
                class="absolute top-2 right-2 text-gray-400 hover:text-white"
                @click="openModal = false"
            >
                &times;
            </button>
        </div>
    </div>
</div>

