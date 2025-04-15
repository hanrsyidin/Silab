<div class="w-64 min-h-screen bg-gray-900 text-white p-6 space-y-4">
    <h3 class="text-xl font-bold mb-4">Menu Admin</h3>

    <ul class="space-y-2">
        <li>
            <button @click="activeMenu = 'schedule'" class="w-full text-left px-4 py-2 rounded hover:bg-gray-700"
                :class="{ 'bg-gray-700': activeMenu === 'schedule' }">
                Jadwal Laboratorium
            </button>
        </li>
        <li>
            <button @click="activeMenu = 'bookings'" class="w-full text-left px-4 py-2 rounded hover:bg-gray-700"
                :class="{ 'bg-gray-700': activeMenu === 'bookings' }">
                Pengajuan Pinjaman
            </button>
        </li>
        <li>
            <button @click="activeMenu = 'history'" class="w-full text-left px-4 py-2 rounded hover:bg-gray-700"
                :class="{ 'bg-gray-700': activeMenu === 'history' }">
                Riwayat Pinjaman
            </button>
        </li>
        <li>
            <button @click="activeMenu = 'students'" class="w-full text-left px-4 py-2 rounded hover:bg-gray-700"
                :class="{ 'bg-gray-700': activeMenu === 'students' }">
                Registrasi Mahasiswa
            </button>
        </li>
    </ul>
</div>
