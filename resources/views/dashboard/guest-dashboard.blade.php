<x-app-layout>
    <div class="flex bg-gray-50 min-h-screen p-4">
        <!-- Sidebar -->
        <div class="w-60 bg-indigo-700 text-white flex-shrink-0 rounded-lg shadow-lg">
            <div class="p-6 text-center">
                <h1 class="text-xl font-bold">Guest Dashboard</h1>
            </div>
            <ul class="flex-1">
                <li class="p-4 hover:bg-indigo-800 transition-colors rounded-lg mx-2">
                    <a href="{{ route('guest.users') }}">Show All Users</a>
                </li>
                <li class="p-4 hover:bg-indigo-800 transition-colors rounded-lg mx-2">
                    <a href="{{ route('profile.edit') }}">Update Your Profile</a>
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
                <!-- Total Guests -->
                <div class="text-center mb-12">
                    <h3 class="text-3xl font-bold text-gray-800">Total Guests</h3>
                    <p class="text-4xl font-extrabold text-indigo-600">{{ $guestCount }}</p>
                </div>

                <!-- Charts Section -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <!-- Guest Growth Over Time Chart -->
                    <div class="bg-gray-50 p-6 rounded-lg shadow-md">
                        <h4 class="text-lg font-bold text-gray-700 text-center mb-4">Guest Growth Over Time</h4>
                        <canvas id="guestGrowthChart"></canvas>
                    </div>

                    <!-- Guest Registration by Day Chart -->
                    <div class="bg-gray-50 p-6 rounded-lg shadow-md">
                        <h4 class="text-lg font-bold text-gray-700 text-center mb-4">Registrations by Day</h4>
                        <canvas id="guestRegistrationChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Integration -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Guest Growth Over Time Chart
        const guestGrowthCtx = document.getElementById('guestGrowthChart').getContext('2d');
        new Chart(guestGrowthCtx, {
            type: 'line',
            data: {
                labels: @json($guestGrowth->pluck('month')),
                datasets: [{
                    label: 'Guest Growth',
                    data: @json($guestGrowth->pluck('count')),
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
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            autoSkip: true,
                            maxTicksLimit: 10
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });

        // Guest Registration by Day Chart
        const guestRegCtx = document.getElementById('guestRegistrationChart').getContext('2d');
        new Chart(guestRegCtx, {
            type: 'bar',
            data: {
                labels: @json($guestRegistrationByDay->pluck('date')),
                datasets: [{
                    label: 'Registrations per Day',
                    data: @json($guestRegistrationByDay->pluck('count')),
                    backgroundColor: '#00C853',
                    borderColor: '#00A152',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            autoSkip: true,
                            maxTicksLimit: 7
                        }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>
