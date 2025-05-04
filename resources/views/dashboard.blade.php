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
</x-app-layout>
