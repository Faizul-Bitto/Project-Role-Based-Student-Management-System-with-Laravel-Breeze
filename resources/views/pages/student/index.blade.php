<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex">
            <!-- Sidebar -->
            <div class="w-60 bg-gray-600 text-gray-100 flex flex-col rounded-lg shadow-md">
                <div class="p-4">
                    <h1 class="text-lg font-semibold text-white"><b>Student</b></h1>
                </div>
                <ul class="flex-1 space-y-2">
                    <li class="p-4 hover:bg-gray-700 rounded-md">
                        <a href="{{ route('student.dashboard') }}" class="text-white">Go Back to Dashboard</a>
                    </li>
                    <li class="p-4 hover:bg-gray-700 rounded-md">
                        <a href="{{ route('student.guests.create') }}" class="text-white">Create Guest User</a>
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

            <!-- Main Content -->
            <div class="flex-1 ml-6 bg-white p-8 rounded-lg shadow-lg">
                <h3 class="text-lg font-semibold text-gray-700 mb-6">List of Users</h3>

                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border border-gray-300 rounded-lg shadow-sm">
                        <thead class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-bold text-gray-100 uppercase tracking-wider border-b-2 border-gray-200">
                                    Name
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-bold text-gray-100 uppercase tracking-wider border-b-2 border-gray-200">
                                    Email
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-bold text-gray-100 uppercase tracking-wider border-b-2 border-gray-200">
                                    Phone
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-bold text-gray-100 uppercase tracking-wider border-b-2 border-gray-200">
                                    Role
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-bold text-gray-100 uppercase tracking-wider border-b-2 border-gray-200">
                                    Student ID
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-bold text-gray-100 uppercase tracking-wider border-b-2 border-gray-200">
                                    Image
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($users as $user)
                                <tr class="hover:bg-gray-50 transition-all duration-300 ease-in-out">
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium border-b border-gray-200">
                                        {{ $user->name }}</td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border-b border-gray-200">
                                        {{ $user->email }}</td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border-b border-gray-200">
                                        {{ $user->phone }}</td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border-b border-gray-200">
                                        {{ $user->getRoleNames()->implode(', ') }}</td>
                                    <td
                                        class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 border-b border-gray-200">
                                        {{ $user->student_id ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($user->image)
                                            <img src="{{ asset($user->image) }}" alt="User Image"
                                                class="h-10 w-10 rounded-full border-2 border-gray-200 shadow-md">
                                        @else
                                            <span class="text-sm text-black">N/A</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Links -->
                <div class="mt-6">
                    {{ $users->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
