<div class="p-6">
    <h2 class="text-xl font-semibold mb-4 text-white">Jadwal Laboratorium</h2>
    <table class="table-auto w-full text-white">
        <thead>
            <tr>
                <th class="px-4 py-2">Ruang</th>
                <th class="px-4 py-2">Jam</th>
                <th class="px-4 py-2">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laboratories as $lab)
                <tr class="border-t">
                    <td class="px-4 py-2">{{ $lab->lab_name }}</td>
                    <td class="px-4 py-2">{{ $lab->schedule }}</td>
                    <td class="px-4 py-2">
                        @if($lab->is_available)
                            <button class="bg-yellow-500 text-white px-3 py-1 rounded">Available</button>
                        @else
                            <button class="bg-gray-500 text-white px-3 py-1 rounded">Booked</button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
