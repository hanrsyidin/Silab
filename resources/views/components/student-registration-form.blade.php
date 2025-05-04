<div class="max-w-md mx-auto bg-white dark:bg-gray-800 p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4 text-gray-900 dark:text-white">Registrasi Mahasiswa</h2>

    @if(session('success'))
        <div class="mb-4 text-green-600 dark:text-green-400 font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('student.register') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block text-sm text-gray-700 dark:text-gray-200">Nama</label>
            <input type="text" name="name" id="name" required
                   class="w-full px-4 py-2 rounded bg-gray-100 dark:bg-gray-700 text-black dark:text-white focus:outline-none">
        </div>

        <div>
            <label for="nim" class="block text-sm text-gray-700 dark:text-gray-200">NIM</label>
            <input type="text" name="nim" id="nim" required
                   class="w-full px-4 py-2 rounded bg-gray-100 dark:bg-gray-700 text-black dark:text-white focus:outline-none">
        </div>

        <div>
            <label for="password" class="block text-sm text-gray-700 dark:text-gray-200">Password</label>
            <input type="password" name="password" id="password" required
                   class="w-full px-4 py-2 rounded bg-gray-100 dark:bg-gray-700 text-black dark:text-white focus:outline-none">
        </div>

        <button type="submit"
                class="w-full bg-yellow-500 hover:bg-yellow-400 text-black font-bold py-2 px-4 rounded">
            Daftar
        </button>
    </form>
</div>
