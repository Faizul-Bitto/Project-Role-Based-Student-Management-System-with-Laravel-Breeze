<x-app-layout>
    <div class="flex bg-gray-50 min-h-screen p-4">
        <!-- Sidebar -->
        <div class="w-60 bg-indigo-700 text-white flex-shrink-0 rounded-lg shadow-lg">
            <div class="p-6 text-center">
                <h1 class="text-xl font-bold">Student Dashboard</h1>
            </div>
            <ul class="flex-1">
                <li class="p-4 hover:bg-indigo-800 transition-colors rounded-lg mx-2">
                    <a href="{{ route('student.dashboard.index') }}">Show Users</a>
                </li>
                <li class="p-4 hover:bg-indigo-800 transition-colors rounded-lg mx-2">
                    <a href="{{ route('student.guests.create') }}">Create Guest User</a>
                </li>
                <li class="p-4 hover:bg-indigo-800 transition-colors rounded-lg mx-2">
                    <a href="{{ route('profile.edit') }}">Your Profile</a>
                </li>
                <li class="p-4 hover:bg-indigo-800 transition-colors rounded-lg mx-2">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left">Logout</button>
                    </form>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-4">
            <div class="bg-white rounded-lg shadow-md p-8">
                <!-- Total Students -->
                <div class="text-center mb-12">
                    <h3 class="text-3xl font-bold text-gray-800">Total Students</h3>
                    <p class="text-4xl font-extrabold text-indigo-600">{{ $studentCount }}</p>
                </div>

                <!-- Charts Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <!-- Student Growth Over Time Chart -->
                    <div class="bg-gray-50 p-6 rounded-lg shadow-md">
                        <h4 class="text-lg font-bold text-gray-700 text-center mb-4">Student Growth Over Time</h4>
                        <canvas id="studentGrowthChart"></canvas>
                    </div>

                    <!-- Student Registration by Day Chart -->
                    <div class="bg-gray-50 p-6 rounded-lg shadow-md">
                        <h4 class="text-lg font-bold text-gray-700 text-center mb-4">Registrations by Day</h4>
                        <canvas id="studentRegistrationChart"></canvas>
                    </div>
                </div>

                <!-- Recently Registered Students -->
                <div class="mt-12">
                    <h3 class="text-xl font-bold text-gray-800 mb-6">Recently Registered Students</h3>
                    <div class="bg-gray-50 p-6 rounded-lg shadow-md">
                        <ul class="divide-y divide-gray-200">
                            @foreach ($recentStudents as $student)
                                <li class="py-4 flex justify-between items-center">
                                    <div>
                                        <p class="font-bold text-gray-800">{{ $student->name }}</p>
                                        <p class="text-sm text-gray-600">{{ $student->email }}</p>
                                    </div>
                                    <p class="text-gray-500 text-sm">{{ $student->created_at->format('Y-m-d H:i') }}</p>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Integration -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Student Growth Over Time Chart
        const studentGrowthCtx = document.getElementById('studentGrowthChart').getContext('2d');
        new Chart(studentGrowthCtx, {
            type: 'line',
            data: {
                labels: @json($studentGrowth->pluck('month')),
                datasets: [{
                    label: 'Student Growth',
                    data: @json($studentGrowth->pluck('count')),
                    borderColor: '#4F46E5',
                    backgroundColor: 'rgba(79, 70, 229, 0.2)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Student Registration by Day Chart
        const studentRegCtx = document.getElementById('studentRegistrationChart').getContext('2d');
        new Chart(studentRegCtx, {
            type: 'bar',
            data: {
                labels: @json($studentRegistrationByDay->pluck('date')),
                datasets: [{
                    label: 'Registrations per Day',
                    data: @json($studentRegistrationByDay->pluck('count')),
                    backgroundColor: '#FF7043',
                    borderColor: '#FF5722',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
</x-app-layout>
