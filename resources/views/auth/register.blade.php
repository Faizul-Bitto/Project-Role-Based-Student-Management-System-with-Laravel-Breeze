<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <!-- Role Selection -->
        <div>
            <x-input-label for="role" :value="__('Select Role')" />
            <select id="role" class="block mt-1 w-full" name="role" required>
                <option value="" disabled selected>{{ __('Select Role') }}</option>
                <option value="Student" {{ old('role') == 'Student' ? 'selected' : '' }}>Student</option>
                <option value="Guest" {{ old('role') == 'Guest' ? 'selected' : '' }}>Guest</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Name -->
        <div class="mt-4">
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')"
                required />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>


        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Student ID (only shown if role is Student) -->
        <div id="student_id_field" class="mt-4" style="display: none;" aria-live="polite">
            <x-input-label for="student_id" :value="__('Student ID')" />
            <x-text-input id="student_id" class="block mt-1 w-full" type="text" name="student_id"
                :value="old('student_id')" />
            <x-input-error :messages="$errors->get('student_id')" class="mt-2" />
        </div>

        <!-- Profile Image -->
        <div class="mt-4">
            <x-input-label for="image" :value="__('Profile Image')" />
            <input id="image" class="block mt-1 w-full" type="file" name="image" />
            <x-input-error :messages="$errors->get('image')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
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
</x-guest-layout>
