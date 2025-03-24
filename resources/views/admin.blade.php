<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

            {{-- Tambahkan tabel laboratorium --}}
            <div class="mt-6 bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <x-laboratory-table />
            </div>
        </div>
    </div>
</x-app-layout>
