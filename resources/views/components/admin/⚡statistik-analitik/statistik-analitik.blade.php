<div wire:init="load">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold">Statistik & Analitik</h1>
            <p class="text-sm text-base-content/60 mt-1">Laporan tren booking dan kepadatan lapangan</p>
        </div>
    </div>
    
    <!-- Analytics Section -->
    <div class="mb-8 mt-8">
        <div class="flex justify-end mb-4 gap-2">
            <select class="select select-bordered" wire:model.live="lapanganId">
                <option value="all">Semua Lapangan</option>
                @foreach($lapangans as $lap)
                    <option value="{{ $lap['id'] }}">{{ $lap['nama_lapangan'] ?? $lap['nama'] }}</option>
                @endforeach
            </select>
            <select class="select select-bordered" wire:model.live="tahun">
                @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                    <option value="{{ $y }}">{{ $y }}</option>
                @endfor
            </select>
        </div>

        <div wire:loading.flex wire:target="lapanganId, tahun" class="items-center justify-center p-10 bg-base-200 rounded-xl mb-6 border border-base-300">
            <span class="loading loading-spinner loading-md"></span>
            <span class="ml-2 font-bold">Memuat data analitik...</span>
        </div>

        <div wire:loading.remove wire:target="lapanganId, tahun">
            @if($analyticsError)
                <div class="alert bg-red-500 text-white mb-6">
                    {{ $analyticsError }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-8" x-data="bookingCharts({
                monthlyData: '{{ json_encode($chartData) }}',
                daysLabels: '{{ json_encode($chartDaysLabels) }}',
                daysData: '{{ json_encode($chartDaysData) }}',
                timesLabels: '{{ json_encode($chartTimesLabels) }}',
                timesData: '{{ json_encode($chartTimesData) }}'
            })">
                <!-- Chart Bulanan -->
                <div class="card bg-base-100 shadow-sm border border-base-200 col-span-1 lg:col-span-2">
                    <div class="card-body p-4">
                        <h3 class="font-bold text-lg mb-4">Tren Booking Bulanan</h3>
                        <div class="w-full h-72 relative" wire:ignore>
                            <canvas id="monthlyChartCanvas"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Chart Hari -->
                <div class="card bg-base-100 shadow-sm border border-base-200 col-span-1">
                    <div class="card-body p-4">
                        <h3 class="font-bold text-lg mb-4">Hari Terlaris</h3>
                        <div class="w-full h-72 relative" wire:ignore>
                            <canvas id="daysChartCanvas"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Chart Jam -->
                <div class="card bg-base-100 shadow-sm border border-base-200 col-span-1">
                    <div class="card-body p-4">
                        <h3 class="font-bold text-lg mb-4">Jam Favorit</h3>
                        <div class="w-full h-72 relative" wire:ignore>
                            <canvas id="timesChartCanvas"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('bookingCharts', (initial) => ({
                init() {
                    let d = { monthlyData: [], daysLabels: [], daysData: [], timesLabels: [], timesData: [] };
                    try {
                        d.monthlyData = JSON.parse(initial.monthlyData || '[]');
                        d.daysLabels = JSON.parse(initial.daysLabels || '[]');
                        d.daysData = JSON.parse(initial.daysData || '[]');
                        d.timesLabels = JSON.parse(initial.timesLabels || '[]');
                        d.timesData = JSON.parse(initial.timesData || '[]');
                    } catch(e) {}
                    
                    this.renderCharts(d);
                    
                    window.addEventListener('analytics-updated', (e) => {
                        let evData = e.detail[0] || e.detail; // Handle Livewire 3 event structure variations
                        this.renderCharts({
                            monthlyData: evData.chartData || [],
                            daysLabels: evData.chartDaysLabels || [],
                            daysData: evData.chartDaysData || [],
                            timesLabels: evData.chartTimesLabels || [],
                            timesData: evData.chartTimesData || []
                        });
                    });
                },
                renderCharts(d) {
                    this.renderChart('monthlyChartCanvas', 'bar', ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'], d.monthlyData, '#3b82f6', 'Jumlah Booking Bulanan');
                    this.renderChart('daysChartCanvas', 'bar', d.daysLabels, d.daysData, '#10b981', 'Total per Hari');
                    this.renderChart('timesChartCanvas', 'bar', d.timesLabels, d.timesData, '#f59e0b', 'Total per Jam');
                },
                renderChart(canvasId, type, labels, data, color, labelTitle) {
                    const ctx = document.getElementById(canvasId);
                    if(!ctx) return;
                    
                    let chart = Chart.getChart(ctx);
                    if(chart) {
                        chart.data.labels = labels;
                        chart.data.datasets[0].data = data;
                        chart.update();
                        return;
                    }
                    
                    new Chart(ctx, {
                        type: type,
                        data: {
                            labels: labels,
                            datasets: [{
                                label: labelTitle,
                                data: data,
                                backgroundColor: color,
                                borderRadius: 4,
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: { precision: 0 }
                                }
                            }
                        }
                    });
                }
            }));
        });
    </script>
