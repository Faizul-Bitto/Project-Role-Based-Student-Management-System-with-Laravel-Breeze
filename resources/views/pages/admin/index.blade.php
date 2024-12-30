<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('User Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex">
            <!-- Sidebar -->
            <div class="w-60 bg-gray-600 text-gray-100 flex flex-col rounded-lg shadow-md">
                <div class="p-4">
                    <h1 class="text-lg font-semibold text-white"><b>Admin</b></h1>
                </div>
                <ul class="flex-1">
                    <li class="p-4 hover:bg-gray-700 rounded-md">
                        <a href="{{ route('admin.dashboard') }}" class="text-white">Go Back to Dashboard</a>
                    </li>
                    <li class="p-4 hover:bg-gray-700 rounded-md">
                        <a href="{{ route('admin.users.create') }}" class="text-white">Create User</a>
                    </li>
                    <li class="p-4 hover:bg-gray-700 rounded-md">
                        <a href="{{ route('profile.edit') }}" class="text-white">Your Profile</a>
                    </li>
                    <li class="p-4 hover:bg-gray-700 rounded-md">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-white">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>

            <!-- Main Section -->
            <div class="flex-1 ml-6 bg-white p-8 shadow-lg rounded-lg">
                <!-- Session Messages -->
                @if (session('success'))
                    <div class="alert alert-success mb-4 text-green-600">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-error mb-4 text-red-600">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- User Table -->
                <table class="min-w-full mt-6 table-auto border-collapse">
                    <thead class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider border-b-2 border-gray-200">
                                Name</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider border-b-2 border-gray-200">
                                Email</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider border-b-2 border-gray-200">
                                Phone</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider border-b-2 border-gray-200">
                                Role</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider border-b-2 border-gray-200">
                                Student ID</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider border-b-2 border-gray-200">
                                Image</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider border-b-2 border-gray-200">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach ($users as $user)
                            <tr class="hover:bg-gray-50 transition-all duration-300 ease-in-out">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-b border-gray-200">
                                    {{ $user->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-b border-gray-200">
                                    {{ $user->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-b border-gray-200">
                                    {{ $user->phone }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-b border-gray-200">
                                    {{ $user->getRoleNames()->implode(', ') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-b border-gray-200">
                                    {{ $user->student_id ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-b border-gray-200">
                                    @if ($user->image)
                                        <img src="{{ asset($user->image) }}" alt="User Image"
                                            class="h-10 w-10 rounded-full border-2 border-gray-200 shadow-md">
                                    @else
                                        <span class="text-black">N/A</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-b border-gray-200">
                                    <div class="flex space-x-4">
                                        <a href="{{ route('admin.users.edit', $user->id) }}"
                                            class="px-4 py-2 text-white bg-yellow-500 hover:bg-yellow-600 rounded-full shadow-md">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-4 py-2 text-white bg-red-500 hover:bg-red-600 rounded-full shadow-md">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination Links -->
                <div class="mt-4">
                    {{ $users->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
