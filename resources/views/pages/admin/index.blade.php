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
                                    {{ $user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-b border-gray-200">
                                    {{ $user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-b border-gray-200">
                                    {{ $user->phone }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-b border-gray-200">
                                    {{ $user->getRoleNames()->implode(', ') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-b border-gray-200">
                                    {{ $user->student_id }}</td>
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
                                        <button onclick="confirmEdit({{ $user->id }})"
                                            class="px-4 py-2 text-white bg-yellow-500 hover:bg-yellow-600 rounded-full transition-all duration-300 ease-in-out shadow-md">
                                            Edit
                                        </button>

                                        <!-- Delete Button Triggering Modal -->
                                        <button onclick="confirmDelete({{ $user->id }})"
                                            class="px-4 py-2 text-white bg-red-500 hover:bg-red-600 rounded-full transition-all duration-300 ease-in-out shadow-md">
                                            Delete
                                        </button>
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

    <!-- Modal for Deleting Confirmation -->
    <div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-lg font-semibold mb-4">Are you sure you want to delete this user?</h3>
            <div class="flex justify-end space-x-4">
                <button onclick="cancelDelete()" class="px-4 py-2 bg-gray-500 text-white rounded-md">Cancel</button>
                <button id="deleteBtn" class="px-4 py-2 bg-red-500 text-white rounded-md">Yes, Delete</button>
            </div>
        </div>
    </div>

    <!-- Modal for Edit Admin Error -->
    <div id="adminEditErrorModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-lg font-semibold mb-4">Admin User Cannot be Edited</h3>
            <div class="flex justify-end">
                <button onclick="closeModal('adminEditErrorModal')"
                    class="px-4 py-2 bg-gray-500 text-white rounded-md">Close</button>
            </div>
        </div>
    </div>

    <script>
        let userIdToDelete = null;
        let userIdToEdit = null;

        // Function to open confirmation modal for delete
        function confirmDelete(userId) {
            userIdToDelete = userId;
            document.getElementById('confirmModal').classList.remove('hidden');
        }

        // Function to cancel delete action
        function cancelDelete() {
            userIdToDelete = null;
            document.getElementById('confirmModal').classList.add('hidden');
        }

        // Handling actual deletion
        document.getElementById('deleteBtn').addEventListener('click', function() {
            if (userIdToDelete) {
                fetch(`/admin/users/${userIdToDelete}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        }
                    }).then(response => response.json())
                    .then(data => {
                        if (data.error) {
                            alert(data.error); // Show error if admin user
                        } else {
                            location.reload(); // Refresh to show changes
                        }
                    });
            }
            cancelDelete();
        });

        // Function to handle the Edit action for Admin users
        function confirmEdit(userId) {
            userIdToEdit = userId;

            // Check if the current user is trying to edit themselves (admin)
            const currentUserId = {{ auth()->id() }};
            if (userId === currentUserId) {
                showAdminEditErrorModal();
            } else {
                window.location.href = `/admin/users/${userId}/edit`;
            }
        }

        // Show error modal for Admin Edit
        function showAdminEditErrorModal() {
            document.getElementById('adminEditErrorModal').classList.remove('hidden');
        }

        // Close any modal
        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
    </script>
</x-app-layout>
