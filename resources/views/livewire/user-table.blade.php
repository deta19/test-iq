<div class="p-6 bg-white shadow rounded-xl">
    <h2 class="text-xl font-semibold mb-4">User Table</h2>

    <div class="mb-4">
        <input
                type="text"
                wire:model.debounce.300ms="search"
                class="w-full md:w-1/3 px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300"
                placeholder="Search users..."
        >
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left text-gray-700">
            <thead class="bg-gray-100 text-xs uppercase font-semibold">
            <tr>
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Registered</th>
                <th class="px-4 py-2 text-right">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($users as $user)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $user->id }}</td>
                    <td class="px-4 py-2">{{ $user->name }}</td>
                    <td class="px-4 py-2">{{ $user->email }}</td>
                    <td class="px-4 py-2">{{ $user->created_at->format('Y-m-d') }}</td>
                    <td class="px-4 py-2 text-right">
                        <button wire:click="edit({{ $user->id }})"
                                class="text-blue-600 hover:underline mr-2">Edit
                        </button>
                         @if(auth()->user()->role === 'admin')
                        <button wire:click="delete({{ $user->id }})"
                                class="text-red-600 hover:underline">Delete
                        </button>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-4 text-center text-gray-500">No users found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
