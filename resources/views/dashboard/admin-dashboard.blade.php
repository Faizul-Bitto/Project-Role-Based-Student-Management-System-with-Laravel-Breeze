<x-app-layout>
    <div class="flex bg-gray-50 min-h-screen p-6">
        <!-- Sidebar -->
        <div class="w-60 bg-indigo-700 text-white flex-shrink-0 rounded-lg shadow-lg">
            <div class="p-6 text-center">
                <h1 class="text-xl font-bold">Admin Dashboard</h1>
            </div>
            <ul class="flex-1">
                <li class="p-4 hover:bg-indigo-800 transition-colors rounded-lg mx-2">
                    <a href="{{ route('admin.users') }}">Show Users</a>
                </li>
                <li class="p-4 hover:bg-indigo-800 transition-colors rounded-lg mx-2">
                    <a href="{{ route('admin.users.create') }}">Create User</a>
                </li>
                <li class="p-4 hover:bg-indigo-800 transition-colors rounded-lg mx-2">
                    <a href="{{ route('profile.edit') }}">Admin Profile</a>
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
        <div class="flex-1 p-6">
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <!-- Total Users -->
                <div class="text-center mb-12">
                    <h3 class="text-3xl font-bold text-gray-800">Total Users</h3>
                    <p class="text-4xl font-extrabold text-indigo-600">{{ $totalUsers }}</p>
                </div>

                <!-- Charts Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-12">
                    <!-- Users by Role Chart -->
                    <div class="bg-gray-50 p-6 rounded-2xl shadow-xl">
                        <h4 class="text-lg font-semibold text-gray-700 text-center mb-6">Users by Role</h4>
                        <canvas id="userChart"></canvas>
                    </div>

                    <!-- User Growth Over Time Chart -->
                    <div class="bg-gray-50 p-6 rounded-2xl shadow-xl">
                        <h4 class="text-lg font-semibold text-gray-700 text-center mb-6">User Growth Over Time</h4>
                        <canvas id="userGrowthChart"></canvas>
                    </div>

                    <!-- User Registration by Day Chart -->
                    <div class="bg-gray-50 p-6 rounded-2xl shadow-xl">
                        <h4 class="text-lg font-semibold text-gray-700 text-center mb-6">User Registration by Day</h4>
                        <canvas id="userRegistrationChart"></canvas>
                    </div>

                    <!-- Email Verification Status Chart -->
                    <div class="bg-gray-50 p-6 rounded-2xl shadow-xl">
                        <h4 class="text-lg font-semibold text-gray-700 text-center mb-6">Email Verification Status</h4>
                        <canvas id="emailVerificationChart"></canvas>
                    </div>
                </div>

                <!-- Recently Registered Users -->
                <div class="mt-12">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Recently Registered Users</h3>
                    <div class="space-y-4">
                        @foreach ($recentUsers as $user)
                            <div
                                class="bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition-shadow duration-300">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h4 class="text-xl font-semibold text-gray-800">{{ $user->name }}</h4>
                                        <p class="text-sm text-blue-600">{{ $user->email }}</p>
                                    </div>
                                    <div class="text-sm text-gray-600">
                                        Registered on
                                        <span class="font-medium">{{ $user->created_at->format('Y-m-d H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Integration -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Users by Role Chart
        const ctx = document.getElementById('userChart').getContext('2d');
        const userChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: @json($roles->pluck('Role')),
                datasets: [{
                    data: @json($roles->pluck('count')),
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
                    hoverBackgroundColor: ['#FF4D6D', '#2481CE', '#FFC245', '#33A9A9'],
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                size: 14,
                                weight: 'bold',
                            },
                        },
                    },
                    tooltip: {
                        backgroundColor: '#333',
                        titleFont: {
                            weight: 'bold',
                        },
                    },
                },
            }
        });

        // User Growth Over Time Chart
        const growthCtx = document.getElementById('userGrowthChart').getContext('2d');
        const userGrowthChart = new Chart(growthCtx, {
            type: 'line',
            data: {
                labels: @json($userGrowth->pluck('month')),
                datasets: [{
                    label: 'User Growth',
                    data: @json($userGrowth->pluck('count')),
                    borderColor: '#36A2EB',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    tension: 0.4,
                    fill: true,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        backgroundColor: '#333',
                        titleFont: {
                            weight: 'bold',
                        },
                    },
                },
            }
        });

        // User Registration by Day Chart
        const registrationCtx = document.getElementById('userRegistrationChart').getContext('2d');
        const userRegistrationChart = new Chart(registrationCtx, {
            type: 'bar',
            data: {
                labels: @json($userRegistrationByDay->pluck('date')),
                datasets: [{
                    data: @json($userRegistrationByDay->pluck('count')),
                    backgroundColor: '#FFA726',
                    hoverBackgroundColor: '#FF7043',
                    borderRadius: 8,
                    barThickness: 20,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        backgroundColor: '#333',
                        titleFont: {
                            weight: 'bold',
                        },
                    },
                },
            }
        });

        // Email Verification Status Chart
        const verifiedCount = {{ $verifiedUsers }};
        const unverifiedCount = {{ $totalUsers - $verifiedUsers }};
        const emailVerificationCtx = document.getElementById('emailVerificationChart').getContext('2d');
        const emailVerificationChart = new Chart(emailVerificationCtx, {
            type: 'doughnut',
            data: {
                labels: ['Verified', 'Unverified'],
                datasets: [{
                    data: [verifiedCount, unverifiedCount],
                    backgroundColor: ['#4CAF50', '#F44336'],
                    hoverBackgroundColor: ['#388E3C', '#D32F2F'],
                    borderWidth: 5,
                    borderColor: '#fff',
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        backgroundColor: '#333',
                        titleFont: {
                            weight: 'bold',
                        },
                    },
                },
            }
        });
    </script>
</x-app-layout>
