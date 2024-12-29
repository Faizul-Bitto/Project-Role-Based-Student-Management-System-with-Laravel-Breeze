<x-app-layout>
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="w-60 bg-gray-600 text-gray-100 flex flex-col mt-12">
            <div class="p-4">
                <h1 class="text-lg font-semibold text-slate-900"><b>Admin Dashboard</b></h1>
            </div>
            <ul class="flex-1">
                <li class="p-4 hover:bg-gray-700"><a href="{{ route('admin.users') }}">Show Users</a></li>
                <li class="p-4 hover:bg-gray-700"><a href="{{ route('admin.users.create') }}">Create User</a></li>
                <li class="p-4 hover:bg-gray-700"><a href="{{ route('profile.edit') }}">Admin Profile</a></li>
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


                        <!-- Total Users -->
                        <h3 class="text-center text-2xl font-bold text-gray-800 mb-8">Total Users:
                            <span class="text-blue-600">{{ $totalUsers }}</span>
                        </h3>

                        <!-- Charts Section -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">
                            <!-- Users by Role Chart -->
                            <div class="bg-gray-100 p-6 rounded-lg shadow-lg">
                                <h4 class="text-center text-lg font-semibold text-gray-700 mb-4">Users by Role</h4>
                                <canvas id="userChart" width="400" height="300"></canvas>
                            </div>

                            <!-- User Growth Over Time Chart -->
                            <div class="bg-gray-100 p-6 rounded-lg shadow-lg">
                                <h4 class="text-center text-lg font-semibold text-gray-700 mb-4">User Growth Over Time
                                </h4>
                                <canvas id="userGrowthChart" width="400" height="300"></canvas>
                            </div>

                            <!-- User Registration by Day Chart -->
                            <div class="bg-gray-100 p-6 rounded-lg shadow-lg">
                                <h4 class="text-center text-lg font-semibold text-gray-700 mb-4">User Registration by
                                    Day
                                    (Last 30 Days)</h4>
                                <canvas id="userRegistrationChart" width="400" height="300"></canvas>
                            </div>

                            <!-- Email Verification Status Chart -->
                            <div class="bg-gray-100 p-6 rounded-lg shadow-lg">
                                <h4 class="text-center text-lg font-semibold text-gray-700 mb-4">Email Verification
                                    Status
                                </h4>
                                <canvas id="emailVerificationChart" width="400" height="300"></canvas>
                            </div>
                        </div>

                        <!-- Recently Registered Users -->
                        <div class="mt-12">
                            <h3 class="text-xl font-semibold text-gray-800 mb-4">Recently Registered Users</h3>
                            <ul class="list-disc pl-5 text-gray-700">
                                @foreach ($recentUsers as $user)
                                    <li>
                                        <span class="font-bold text-gray-800">{{ $user->name }}</span>
                                        (<span class="text-blue-600">{{ $user->email }}</span>)
                                        - Registered on
                                        <span class="text-gray-600">{{ $user->created_at->format('Y-m-d H:i') }}</span>
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
                }]
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
                }]
            }
        });
    </script>
</x-app-layout>
