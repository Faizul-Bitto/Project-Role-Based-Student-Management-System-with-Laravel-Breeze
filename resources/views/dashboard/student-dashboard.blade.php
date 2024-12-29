<x-app-layout>
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="w-60 bg-gray-600 text-gray-100 flex flex-col mt-12">
            <div class="p-4">
                <h1 class="text-lg font-semibold text-slate-900"><b>Student Dashboard</b></h1>
            </div>
            <ul class="flex-1">
                <li class="p-4 hover:bg-gray-700"><a href="{{ route('student.dashboard') }}">Show Users</a></li>
                <li class="p-4 hover:bg-gray-700"><a href="{{ route('student.guests.create') }}">Create Guest User</a>
                </li>
                <li class="p-4 hover:bg-gray-700"><a href="{{ route('profile.edit') }}">Your Profile</a></li>
                <li class="p-4 hover:bg-gray-700">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="flex-1">
            <!-- Content Area -->
            <div class="py-12 bg-gray-50">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">

                        <!-- Total Students -->
                        <h3 class="text-center text-2xl font-bold text-gray-800 mb-8">Total Students:
                            <span class="text-blue-600">{{ $studentCount }}</span>
                        </h3>

                        <!-- Charts Section -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">
                            <!-- Student Growth Over Time Chart -->
                            <div class="bg-gray-100 p-6 rounded-lg shadow-lg">
                                <h4 class="text-center text-lg font-semibold text-gray-700 mb-4">Student Growth Over
                                    Time</h4>
                                <canvas id="studentGrowthChart" width="400" height="300"></canvas>
                            </div>

                            <!-- Student Registration by Day Chart -->
                            <div class="bg-gray-100 p-6 rounded-lg shadow-lg">
                                <h4 class="text-center text-lg font-semibold text-gray-700 mb-4">Student Registration by
                                    Day (Last 30 Days)</h4>
                                <canvas id="studentRegistrationChart" width="400" height="300"></canvas>
                            </div>
                        </div>

                        <!-- Recently Registered Students -->
                        <div class="mt-12">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4">Recently Registered Students</h3>
                            <ul class="list-disc pl-5 text-gray-700">
                                @foreach ($recentStudents as $student)
                                    <li>
                                        <span class="font-bold text-gray-800">{{ $student->name }}</span>
                                        (<span class="text-blue-600">{{ $student->email }}</span>)
                                        - Registered on
                                        <span
                                            class="text-gray-600">{{ $student->created_at->format('Y-m-d H:i') }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
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
        const studentGrowthChart = new Chart(studentGrowthCtx, {
            type: 'line',
            data: {
                labels: @json($studentGrowth->pluck('month')),
                datasets: [{
                    label: 'Student Growth',
                    data: @json($studentGrowth->pluck('count')),
                    borderColor: '#36A2EB',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    fill: true,
                }]
            }
        });

        // Student Registration by Day Chart
        const studentRegCtx = document.getElementById('studentRegistrationChart').getContext('2d');
        const studentRegistrationChart = new Chart(studentRegCtx, {
            type: 'bar',
            data: {
                labels: @json($studentRegistrationByDay->pluck('date')),
                datasets: [{
                    label: 'Registrations per Day',
                    data: @json($studentRegistrationByDay->pluck('count')),
                    backgroundColor: '#FF7043',
                    hoverBackgroundColor: '#FF5722',
                }]
            }
        });
    </script>
</x-app-layout>
