<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create User') }}
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
                        <a href="{{ route('admin.users') }}" class="text-white">Users List</a>
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

            <!-- Form Section -->
            <div class="flex-1 ml-6 bg-white p-8 shadow-lg rounded-lg">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Create a New User</h3>

                <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf

                    <!-- Role Selection -->
                    <div>
                        <x-input-label for="role" :value="__('Select Role')" />
                        <select id="role"
                            class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            name="role" required>
                            <option value="" disabled selected>{{ __('Select Role') }}</option>
                            <option value="Student" {{ old('role') == 'Student' ? 'selected' : '' }}>Student</option>
                            <option value="Guest" {{ old('role') == 'Guest' ? 'selected' : '' }}>Guest</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name"
                            class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email"
                            class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Phone -->
                    <div>
                        <x-input-label for="phone" :value="__('Phone')" />
                        <x-text-input id="phone"
                            class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            type="text" name="phone" :value="old('phone')" required />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password"
                            class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <x-text-input id="password_confirmation"
                            class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <!-- Student ID (only shown if role is Student) -->
                    <div id="student_id_field" class="mt-4" style="display: none;" aria-live="polite">
                        <x-input-label for="student_id" :value="__('Student ID')" />
                        <x-text-input id="student_id"
                            class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            type="text" name="student_id" :value="old('student_id')" />
                        <x-input-error :messages="$errors->get('student_id')" class="mt-2" />
                    </div>

                    <!-- Profile Image -->
                    <div>
                        <x-input-label for="image" :value="__('Profile Image')" />
                        <input id="image"
                            class="block w-full mt-1 border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            type="file" name="image" />
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end">
                        <a href="{{ route('admin.users') }}"
                            class="text-sm text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 rounded-lg px-4 py-2">
                            {{ __('Cancel') }}
                        </a>
                        <x-primary-button class="ml-4">
                            {{ __('Create User') }}
                        </x-primary-button>
                    </div>
                </form>

                <script>
                    document.getElementById('role').addEventListener('change', function() {
                        var studentIdField = document.getElementById('student_id_field');
                        var studentIdInput = document.getElementById('student_id');

                        if (this.value === 'Student') {
                            studentIdField.style.display = 'block';
                        } else {
                            studentIdField.style.display = 'none';
                            studentIdInput.value = ''; // Clear the student ID field when not a student
                        }
                    });

                    // Trigger change event on page load to hide/show student ID field based on previous selection
                    document.getElementById('role').dispatchEvent(new Event('change'));
                </script>
            </div>
        </div>
    </div>
</x-app-layout>
