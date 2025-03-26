<x-app-layout>
    <header class="bg-gray-900 p-4 flex items-center justify-between">
        <div class="text-yellow-400 font-bold text-xl">
            SILAB Fasilkom Unsri
        </div>
    </header>

    <div class="min-h-screen bg-black text-white p-6">
        <h2 class="text-xl font-semibold mb-4 text-white">Jadwal Laboratorium</h2>

        <div class="bg-gray-800 p-4 rounded-lg">
            <x-laboratory-table />
        </div>
    </div>
</x-app-layout>
