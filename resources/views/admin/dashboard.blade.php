<x-admin.layout>

    <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight text-balance">Admin Command Center</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium italic">Global Supply Chain Integrity Real-time Monitor</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.allocations.create') }}" class="bg-[#064E3B] text-white px-5 py-2.5 text-xs font-bold rounded-lg shadow-md hover:shadow-lg transition-all flex items-center gap-2 uppercase tracking-widest">
                <i class="fa-solid fa-plus"></i> Add Allocation Quota
            </a>
        </div>
    </div>

    <!-- Core Statistics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
        <!-- Minted Items Tracker -->
        <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-boxes-stacked text-6xl text-[#1B4332]"></i>
            </div>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Total Items Minted</p>
            <h3 class="text-4xl font-black text-[#1B4332]">{{ number_format($totalItemsMinted) }}</h3>
            <div class="mt-4 flex items-center gap-2 text-[#52B788] text-xs font-bold">
                <i class="fa-solid fa-arrow-trend-up"></i>
                <span>+{{ number_format($itemsMintedToday) }} today</span>
            </div>
        </div>

        <!-- Active Batches Tracker -->
        <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-truck-ramp-box text-6xl text-[#1B4332]"></i>
            </div>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Active Batches</p>
            <h3 class="text-4xl font-black text-[#1B4332]">{{ $totalActiveBatches }}</h3>
            <div class="mt-4 flex items-center gap-2 text-gray-400 text-xs font-bold">
                <i class="fa-solid fa-location-dot"></i>
                <span>Across {{ $totalActiveStates }} {{ Str::plural('State', $totalActiveStates) }}</span>
            </div>
        </div>

        <!-- Positive Feedback Tracker -->
        <div class="bg-white p-8 rounded-[2rem] border border-gray-100 shadow-sm relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-face-smile text-6xl text-green-600"></i>
            </div>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Good Feedback</p>
            <h3 class="text-4xl font-black text-green-600">{{ number_format($goodFeedbackCount) }}</h3>
            <div class="mt-4 flex items-center gap-2 text-green-600/60 text-xs font-bold">
                <i class="fa-solid fa-check-double"></i>
                <span>Authenticity Confirmed</span>
            </div>
        </div>

        <!-- Critical Alerts Tracker -->
        <div class="bg-red-50 p-8 rounded-[2rem] border border-red-100 shadow-sm relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-triangle-exclamation text-6xl text-red-600"></i>
            </div>
            <p class="text-[10px] font-black text-red-400 uppercase tracking-widest mb-2">Critical Alerts</p>
            <h3 class="text-4xl font-black text-red-600">{{ $criticalAlertsCount }}</h3>
            <div class="mt-4 flex items-center gap-2 text-red-600 text-xs font-bold">
                <i class="fa-solid fa-bell {{ $criticalAlertsCount > 0 ? 'animate-pulse' : '' }}"></i>
                <span>Requires Investigation</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        <!-- Territorial Coverage Section -->
        <div class="lg:col-span-1 bg-[#1B4332] p-10 rounded-[3rem] text-white relative overflow-hidden shadow-xl shadow-[#1B4332]/20">
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-white/5 rounded-full blur-3xl"></div>
            
            <h2 class="text-xs font-black uppercase tracking-[0.2em] text-[#52B788] mb-8 flex items-center gap-3">
                <span class="w-8 h-[2px] bg-[#52B788]"></span>
                Territorial Coverage
            </h2>
            
            <div class="space-y-6">
                <div class="flex items-end justify-between">
                    <div>
                        <p class="text-5xl font-black">{{ $totalActiveStates }}</p>
                        <p class="text-sm font-bold opacity-60">Active States</p>
                    </div>
                    <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center border border-white/10">
                        <i class="fa-solid fa-map-location-dot text-2xl text-[#52B788]"></i>
                    </div>
                </div>

                <div class="pt-6 border-t border-white/10">
                    <p class="text-[10px] font-black uppercase tracking-widest text-[#52B788] mb-4">Deployment Regions</p>
                    <div class="flex flex-wrap gap-2">
                        @forelse($activeStatesList as $state)
                            <span class="px-3 py-1 bg-white/10 rounded-lg text-[10px] font-bold border border-white/5 uppercase">
                                {{ $state }}
                            </span>
                        @empty
                            <span class="text-xs text-white/40 italic">No regions deployed yet</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Real-time Chart Block Asset -->
        <div class="lg:col-span-2 bg-white p-10 rounded-[3rem] border border-gray-100 shadow-sm flex flex-col justify-between">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xs font-black uppercase tracking-[0.2em] text-[#1B4332] flex items-center gap-3">
                        <span class="w-8 h-[2px] bg-[#52B788]"></span>
                        Regional Supply Matrix
                    </h2>
                    <div class="px-4 py-1.5 bg-emerald-50 rounded-full text-[10px] font-black text-[#1B4332] uppercase tracking-widest border border-emerald-100">
                        Live Volumes
                    </div>
                </div>

                <!-- Chart Canvas Container -->
                <div class="relative w-full aspect-[2/1] min-h-[250px]">
                    <canvas id="regionalSupplyChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- chart js script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const ctx = document.getElementById('regionalSupplyChart').getContext('2d');
            
            const labels = {!! json_encode($chartLabels) !!};
            const dataValues = {!! json_encode($chartValues) !!};

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels.map(label => label.toUpperCase()),
                    datasets: [{
                        label: 'Quota Utilization',
                        data: dataValues,
                        borderColor: '#1B4332',
                        borderWidth: 3,
                        pointBackgroundColor: '#52B788',
                        pointBorderColor: '#1B4332',
                        pointBorderWidth: 2,
                        pointRadius: 6,
                        pointHoverRadius: 8,
                        tension: 0.35,
                        fill: true,
                        backgroundColor: function(context) {
                            const chart = context.chart;
                            const {ctx, chartArea} = chart;
                            if (!chartArea) return null;
                            
                            const gradient = ctx.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                            gradient.addColorStop(0, 'rgba(27, 67, 50, 0.2)');
                            gradient.addColorStop(1, 'rgba(255, 255, 255, 0)');
                            return gradient;
                        }
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#000',
                            padding: 12,
                            titleFont: { size: 11, weight: 'bold' },
                            bodyFont: { size: 13 },
                            cornerRadius: 8,
                            callbacks: {
                                // Appends a '%' sign when hovering over individual points
                                label: function(context) {
                                    return ` Utilized: ${context.parsed.y}%`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 10, weight: '900' }, color: '#9CA3AF' }
                        },
                        y: {
                            grid: { color: '#F3F4F6' },
                            border: { dash: [5, 5] },
                            min: 0,   // Force line chart floor boundary to 0%
                            max: 100, // Lock line chart ceiling boundary to 100%
                            ticks: {
                                font: { size: 11, weight: '700' },
                                color: '#9CA3AF',
                                // Appends a '%' sign on the vertical ruler markings
                                callback: function(value) {
                                    return value + '%';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-admin.layout>