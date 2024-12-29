<x-app-layout>
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="w-60 bg-gray-600 text-gray-100 flex flex-col mt-12">
            <div class="p-4">
                <h1 class="text-lg font-semibold text-slate-900"><b>Guest Dashboard</b></h1>
            </div>
            <ul class="flex-1">
                <li class="p-4 hover:bg-gray-700"><a href="{{ route('guest.users') }}">Show All Users</a></li>
                <li class="p-4 hover:bg-gray-700"><a href="{{ route('profile.edit') }}">Update Your Profile</a></li>
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

                        <!-- Total Guests -->
                        <h3 class="text-center text-2xl font-bold text-gray-800 mb-8">Total Guests:
                            <span class="text-blue-600">{{ $guestCount }}</span>
                        </h3>

                        <!-- Charts Section -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">
                            <!-- Guest Growth Over Time Chart -->
                            <div class="bg-gray-100 p-6 rounded-lg shadow-lg">
                                <h4 class="text-center text-lg font-semibold text-gray-700 mb-4">Guest Growth Over Time
                                </h4>
                                <canvas id="guestGrowthChart" width="400" height="300"></canvas>
                            </div>

                            <!-- Guest Registration by Day Chart -->
                            <div class="bg-gray-100 p-6 rounded-lg shadow-lg">
                                <h4 class="text-center text-lg font-semibold text-gray-700 mb-4">Guest Registration by
                                    Day (Last 30 Days)</h4>
                                <canvas id="guestRegistrationChart" width="400" height="300"></canvas>
                            </div>
                        </div>


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
        const guestGrowthChart = new Chart(guestGrowthCtx, {
            type: 'line',
            data: {
                labels: @json($guestGrowth->pluck('month')),
                datasets: [{
                    label: 'Guest Growth',
                    data: @json($guestGrowth->pluck('count')),
                    borderColor: '#FFEB3B',
                    backgroundColor: 'rgba(255, 235, 59, 0.2)',
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
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.raw + ' Guests';
                            }
                        }
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
        const guestRegistrationChart = new Chart(guestRegCtx, {
            type: 'bar',
            data: {
                labels: @json($guestRegistrationByDay->pluck('date')),
                datasets: [{
                    label: 'Registrations per Day',
                    data: @json($guestRegistrationByDay->pluck('count')),
                    backgroundColor: '#00C853',
                    hoverBackgroundColor: '#00E676',
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
