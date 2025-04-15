<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex" x-data="{ activeMenu: 'schedule' }"> <!-- State activeMenu -->

        {{-- Sidebar Admin --}}
        <x-admin.sidebar-admin/>

        {{-- Konten Dinamis Berdasarkan Menu --}}
        <div class="flex-1 p-6">
            <div class="mt-6 bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <template x-if="activeMenu === 'schedule'">
                    <div>
                        <x-laboratory-table />
                    </div>
                </template>

                <template x-if="activeMenu === 'bookings'">
                    <x-borrowing-requests />
                </template>

                <template x-if="activeMenu === 'history'">
                    <div class="text-white">Komponen untuk Riwayat Pinjaman (belum dibuat)</div>
                </template>

                <template x-if="activeMenu === 'students'">
                    <div class="text-white">Komponen untuk Registrasi Mahasiswa (belum dibuat)</div>
                </template>
            </div>
        </div>
    </div>
</x-app-layout>