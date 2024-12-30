<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
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
                <form method="POST" action="{{ route('admin.users.update', $user->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Role Selection -->
                    <div>
                        <x-input-label for="role" :value="__('Select Role')" />
                        <select id="role" class="block mt-1 w-full" name="role" required>
                            <option value="" disabled>{{ __('Select Role') }}</option>
                            <option value="Student" {{ $user->role == 'Student' ? 'selected' : '' }}>Student</option>
                            <option value="Guest" {{ $user->role == 'Guest' ? 'selected' : '' }}>Guest</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>

                    <!-- Name -->
                    <div class="mt-4">
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                            :value="old('name', $user->name)" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                            :value="old('email', $user->email)" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Phone -->
                    <div class="mt-4">
                        <x-input-label for="phone" :value="__('Phone')" />
                        <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone"
                            :value="old('phone', $user->phone)" required />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password (Leave blank to keep current)')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                            name="password_confirmation" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <!-- Student ID (only shown if role is Student) -->
                    <div id="student_id_field" class="mt-4" style="display: none;" aria-live="polite">
                        <x-input-label for="student_id" :value="__('Student ID')" />
                        <x-text-input id="student_id" class="block mt-1 w-full" type="text" name="student_id"
                            :value="old('student_id', $user->student_id)" />
                        <x-input-error :messages="$errors->get('student_id')" class="mt-2" />
                    </div>

                    <!-- Profile Image -->
                    <div class="mt-4">
                        <x-input-label for="image" :value="__('Profile Image')" />
                        <input id="image" class="block mt-1 w-full" type="file" name="image" />
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                        @if ($user->image)
                            <div class="mt-2">
                                <img src="{{ asset($user->image) }}" alt="Profile Image" class="w-20 h-20 rounded">
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            href="{{ route('admin.users') }}">
                            {{ __('Cancel') }}
                        </a>

                        <x-primary-button class="ms-4">
                            {{ __('Update User') }}
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
