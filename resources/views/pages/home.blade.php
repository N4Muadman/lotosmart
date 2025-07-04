@extends('layout')

@section('content')
<div id="app">
        <!-- Hero Section -->
        <section class="hero bg-gradient-to-r from-blue-600 to-blue-800 text-white py-20">
            <div class="hero-content container mx-auto text-center fade-in">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Phân tích thông minh<br>Quyết định sáng suốt</h1>
                <p class="text-lg mb-8">Hệ thống phân tích lô đề tiên tiến nhất với AI và Machine Learning, giúp bạn đưa ra quyết định dựa trên dữ liệu chính xác.</p>
                <div class="cta-buttons flex justify-center gap-4">
                    <a href="#dashboard" class="btn btn-primary bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">Bắt đầu miễn phí</a>
                    <a href="#demo" class="btn btn-secondary border border-white text-white py-2 px-4 rounded hover:bg-white hover:text-blue-600">Xem demo</a>
                </div>
            </div>
        </section>

        <div class="container mx-auto px-4 py-8">
            <section class="live-ticker slide-in bg-white shadow rounded-lg p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 pb-3">
                    <div class="ticker-header flex items-center gap-2">
                        <div class="live-indicator w-3 h-3 bg-red-500 rounded-full animate-pulse"></div>
                        <h3 class="text-lg font-semibold"><i class="fas fa-broadcast-tower"></i> Kết quả trực tiếp</h3>
                        <span id="loading-indicator" class="loading hidden w-5 h-5 border-2 border-t-blue-500 rounded-full animate-spin"></span>
                    </div>
                    <div class="flex justify-end gap-4">
                        <input type="date" id="filter-date" class="filter-input border rounded px-2 py-1 text-black">
                        <select id="filter-region" class="filter-input border rounded px-2 py-1 text-black">
                            <option value="XSMB">Miền Bắc</option>
                            <option value="XSMT">Miền Trung</option>
                            <option value="XSMN">Miền Nam</option>
                        </select>
                    </div>
                </div>

                <div id="ticker-content" class="ticker-content grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Lottery Results and Statistics will be dynamically inserted here -->
                </div>

                <!-- Quick Stats -->
                <div class="mt-6">
                    <h3 class="mb-3 text-lg"><i class="fas fa-robot"></i> Lịch sử dự đoán giải đặc biệt (10 số/ngày) của AI và kết quả đối chiếu thực tế cách đây 10 ngày</h3>
                    <div id="quick-stats" class="quick-stats grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                        <!-- Quick stats will be inserted here -->
                    </div>

                    <h3 class="mb-3 text-lg"><i class="fas fa-robot"></i> Kết quả dự đoán tất cả giải (10 số/ngày) của AI và kết quả đối chiếu thực tế của ngày hôm nay</h3>
                    {{-- <div id="quick-stats" class="quick-stats grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                        <!-- Quick stats will be inserted here -->
                    </div> --}}
                </div>
            </section>

            <section id="dashboard" class="dashboard mt-8">
                <h2 class="section-title text-2xl font-bold mb-6">Thống kê kết quả</h2>

                <!-- Analysis Tools -->
                <div class="analysis-tools bg-white shadow rounded-lg p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="dashboard-card mx-auto">
                            <div class="card-header">
                                <h3 class="card-title text-lg font-semibold">Chọn số để thống kê</h3>
                            </div>
                            <div class="heatmap-container">
                                <div id="heatmap-grid" class="heatmap-grid grid grid-cols-10 gap-1">
                                    <!-- Heatmap cells will be inserted here -->
                                </div>
                            </div>
                        </div>
                        <div class="tool-filters space-y-4">
                            <div class="filter-group">
                                <label class="filter-label font-medium">Biên độ</label>
                                <select id="stats-days-period" class="filter-input border rounded px-2 py-1 w-full">
                                    <option value="7">7 ngày qua</option>
                                    <option value="30">30 ngày qua</option>
                                    <option value="45">45 ngày qua</option>
                                    <option value="60">60 ngày qua</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label class="filter-label font-medium">Miền</label>
                                <select id="stats-region" class="filter-input border rounded px-2 py-1 w-full">
                                    <option value="XSMB">Miền Bắc</option>
                                    <option value="XSMT">Miền Trung</option>
                                    <option value="XSMN">Miền Nam</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label class="filter-label font-medium">Ngày thống kê</label>
                                <input type="date" id="stats-date" class="filter-input border rounded px-2 py-1 w-full">
                            </div>
                            <button id="submit-stats" class="btn btn-primary w-full">Áp dụng bộ lọc</button>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Grid -->
                <div class="dashboard-grid grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                    <div class="dashboard-card bg-white shadow rounded-lg p-6">
                        <div class="card-header flex justify-between items-center">
                            <h3 class="card-title text-lg font-semibold">Thống kê số lần ra của giải đặc biệt</h3>
                            <i class="fas fa-chart-bar card-icon text-blue-500"></i>
                        </div>
                        <div class="chart-container">
                            <canvas id="frequencyChart"></canvas>
                        </div>
                    </div>
                    <div class="dashboard-card bg-white shadow rounded-lg p-6">
                        <div class="card-header flex justify-between items-center">
                            <h3 class="card-title text-lg font-semibold">Thống kê số lần ra của tất cả giải</h3>
                            <i class="fas fa-chart-bar card-icon text-blue-500"></i>
                        </div>
                        <div class="chart-container">
                            <canvas id="trendChart"></canvas>
                        </div>
                    </div>
                    <div class="dashboard-card bg-white shadow rounded-lg p-6">
                        <div class="card-header flex justify-between items-center">
                            <h3 class="card-title text-lg font-semibold">Thống kê số ngày chưa ra</h3>
                            <i class="fas fa-chart-line card-icon text-blue-500"></i>
                        </div>
                        <div class="chart-container">
                            <canvas id="gapChart"></canvas>
                        </div>
                    </div>
                </div>
            </section>

            <!-- History Modal -->
            <div id="history-modal" class="hidden fixed inset-0 bg-gray-500/75 z-10">
                <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                    <div class="flex min-h-full items-center justify-center p-4">
                        <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all w-full max-w-6xl">
                            <div class="header-background-modal px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-800 text-white">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-lg font-semibold">Lịch Sử Dự Đoán AI</h3>
                                            <p class="text-blue-100 text-sm">Kết quả dự đoán 10 ngày gần nhất</p>
                                        </div>
                                    </div>
                                    <button id="close-history-modal" class="text-white/80 hover:text-white">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div id="history-content" class="max-h-[70vh] overflow-y-auto p-6">
                                <!-- History items will be inserted here -->
                            </div>
                            <div class="bg-gray-50 px-6 py-4 border-t">
                                <button id="close-history-modal-footer" class="btn-close inline-flex items-center px-3 py-2 text-sm rounded-md bg-blue-500 text-white">Đóng</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Toast Container -->
            <div id="toastContainer" class="toast-container fixed bottom-4 right-4 space-y-2"></div>
        </div>
    </div>

    <script>
        const app = {
            data: {
                loading: false,
                submitting: false,
                showHistoryModal: false,
                filters: {
                    date: '',
                    region: 'XSMB'
                },
                statisticsForm: {
                    days_period: '30',
                    region: 'XSMB',
                    date: ''
                },
                lotteryXSMB: {},
                lotoNumbersXSMB: [],
                lotteryXSTN: [],
                provinceXSTN: [],
                currentDate: new Date(),
                region: 'XSMB',
                aiStats: {
                    accuracy_percent: 0,
                    latest_hit: null,
                    max_streak: 0
                },
                predictionHistory: [],
                selectedNumbers: [],
                lotteryDrawing: null,
                charts: {
                    frequency: null,
                    trend: null,
                    gap: null
                },
                chartData: {
                    specialPrizeStats: [],
                    allNumberStats: [],
                    lastAppearanceRecords: []
                },
                toasts: [],
                toastId: 0,
                aiPredictions: [
                    { title: 'Bạch thủ lô XSMB', numbers: [47], confidence: 87 },
                    { title: 'Song thủ lô', numbers: [23, 78], confidence: 74 },
                    { title: '3 càng', numbers: [5, 6, 7], confidence: 65 },
                    { title: 'Dàn đề 10 số', numbers: [12, 90, 34, 56, 78], confidence: 82, style: { fontSize: '0.7rem' } }
                ]
            },

            prizeStructure: {
                XSMB: [
                    { code: 'Mã ĐB', key: 'special_code', gridClass: 'grid grid-cols-6', className: 'date-codes', count: 6 },
                    { code: 'G.ĐB', key: 'special_prize', gridClass: 'grid grid-cols-1', className: 'special-prize', count: 1 },
                    { code: 'G.1', key: 'first_prize', gridClass: 'grid grid-cols-1', className: '', count: 1 },
                    { code: 'G.2', key: 'second_prize', gridClass: 'grid grid-cols-2', className: '', count: 2 },
                    { code: 'G.3', key: 'third_prize', gridClass: 'grid grid-cols-3', className: '', count: 6 },
                    { code: 'G.4', key: 'fourth_prize', gridClass: 'grid grid-cols-2 md:grid-cols-4', className: '', count: 4 },
                    { code: 'G.5', key: 'fifth_prize', gridClass: 'grid grid-cols-3', className: '', count: 6 },
                    { code: 'G.6', key: 'sixth_prize', gridClass: 'grid grid-cols-3', className: '', count: 3 },
                    { code: 'G.7', key: 'seventh_prize', gridClass: 'grid grid-cols-4', className: 'last-two', count: 4 }
                ],
                XSTN: [
                    { code: 'G', key: 'province', className: 'date-codes', count: 1 },
                    { code: '8', key: 'eighth_prize', className: 'last-two', count: 1 },
                    { code: '7', key: 'seventh_prize', className: '', count: 1 },
                    { code: '6', key: 'sixth_prize', className: '', count: 3 },
                    { code: '5', key: 'fifth_prize', className: '', count: 1 },
                    { code: '4', key: 'fourth_prize', className: '', count: 7 },
                    { code: '3', key: 'third_prize', className: '', count: 2 },
                    { code: '2', key: 'second_prize', className: '', count: 1 },
                    { code: '1', key: 'first_prize', className: '', count: 1 },
                    { code: 'ĐB', key: 'special_prize', className: 'special-prize', count: 1 }
                ]
            },

            init() {
                this.setupEventListeners();
                this.initializeData();
                this.renderHeatmap();
            },

            setupEventListeners() {
                document.getElementById('filter-date').addEventListener('change', () => this.LotteryFilter());
                document.getElementById('filter-region').addEventListener('change', () => this.LotteryFilter());
                document.getElementById('submit-stats').addEventListener('click', () => this.submitStatistics());
                document.getElementById('close-history-modal').addEventListener('click', () => this.closeHistoryModal());
                document.getElementById('close-history-modal-footer').addEventListener('click', () => this.closeHistoryModal());
                document.getElementById('history-modal').addEventListener('click', (e) => {
                    if (e.target === document.getElementById('history-modal')) this.closeHistoryModal();
                });
            },

            async initializeData() {
                await Promise.all([
                    this.fetchLotteryResult(),
                    this.fetchAiPredictionData(),
                    this.fetchStatisticsData(),
                ]);
                this.renderTickerContent();
                this.initLotteryDrawing(this.data.filters.region, this.data.filters.date);
                this.setupSocketConnection();
                this.renderQuickStats();
                this.initializeCharts();
            },

            async fetchLotteryResult() {
                this.data.loading = true;
                document.getElementById('loading-indicator').classList.remove('hidden');
                try {
                    const params = new URLSearchParams({
                        date: this.data.filters.date,
                        region: this.data.filters.region
                    });
                    const response = await fetch(`{{ config('api_endpoint.get_lottery_result') }}?${params}`, {
                        headers: { 'Accept': 'application/json' }
                    });
                    if (!response.ok) throw new Error('Failed to fetch lottery data');
                    const data = await response.json();

                    if (data.region == 'XSMB'){
                        this.data.lotteryXSMB = data.lottery || {};
                        this.data.lotoNumbersXSMB = Object.values(data.loto || {});
                    }else{
                        this.data.lotteryXSTN = data.results.length > 0 ? data.results : {0:{},1:{},2:{}};
                        this.data.provinceXSTN = Object.values(this.data.lotteryXSTN).map((it) => it.lottery?.province || null);
                    }
                    this.data.currentDate = data.date;
                    this.data.region = data.region;

                } catch (error) {
                    this.showToast('Có lỗi xảy ra khi lấy dữ liệu xổ số', 'error');
                    console.error(error);
                } finally {
                    this.data.loading = false;
                    document.getElementById('loading-indicator').classList.add('hidden');
                }
            },

            async fetchAiPredictionData() {
                try {
                    const params = new URLSearchParams({
                        region: this.data.filters.region
                    });
                    const response = await fetch(`{{ config('api_endpoint.ai_prediction_special_prize') }}?${params}`, {
                        headers: { 'Accept': 'application/json' }
                    });
                    if (!response.ok) throw new Error('Failed to fetch AI prediction data');
                    const data = await response.json();
                    const specialPrize = data.special_prize;
                    this.data.aiStats = {
                        accuracy_percent: specialPrize.accuracy_percent || 0,
                        latest_hit: specialPrize.latest_hit || null,
                        max_streak: specialPrize.max_streak || 0
                    };
                    this.data.predictionHistory = Object.values(specialPrize.stats || {});
                } catch (error) {
                    this.showToast('Không thể tải dữ liệu dự đoán AI', 'error');
                    console.error(error);
                }
            },

            async fetchStatisticsData() {
                this.data.submitting = true;
                document.getElementById('submit-stats').textContent = 'Đang xử lý'

                try {
                    const params = new URLSearchParams({
                        numbers: this.data.selectedNumbers.join(','),
                        date: this.data.statisticsForm.date,
                        days_period: this.data.statisticsForm.days_period,
                        region: this.data.statisticsForm.region
                    });
                    const response = await fetch(`{{ config('api_endpoint.base_statis') }}?${params}`, {
                        headers: { 'Accept': 'application/json' }
                    });
                    if (!response.ok) throw new Error('Failed to fetch statistics data');
                    const data = await response.json();
                    this.data.chartData.specialPrizeStats = data.special_prize_stats || [];
                    this.data.chartData.allNumberStats = data.all_number_stats || [];
                    this.data.chartData.lastAppearanceRecords = data.lastAppearanceRecords || [];
                    this.initializeCharts();
                } catch (error) {
                    this.showToast('Có lỗi xảy ra khi lấy dữ liệu thống kê', 'error');
                    console.error(error);
                } finally {
                    this.data.submitting = false;
                    document.getElementById('submit-stats').textContent = 'Áp dụng bộ lọc';
                }
            },

            async submitStatistics() {
                this.data.statisticsForm.date = document.getElementById('stats-date').value;
                this.data.statisticsForm.region = document.getElementById('stats-region').value;
                this.data.statisticsForm.days_period = document.getElementById('stats-days-period').value;
                await this.fetchStatisticsData();
            },

            async LotteryFilter() {
                this.data.filters.date = document.getElementById('filter-date').value;
                this.data.filters.region = document.getElementById('filter-region').value;
                if (this.data.lotteryDrawing?.isDrawing) {
                    this.data.lotteryDrawing.stopAllDrawings();
                }
                await this.fetchLotteryResult();
                await this.fetchAiPredictionData();
                this.renderTickerContent();
                await this.initLotteryDrawing(this.data.filters.region, this.data.filters.date, this.data.provinceXSTN);
            },

            getPrizeNumbers(prize) {
                const data = this.data.lotteryXSMB[prize.key] || [];
                const result = [];
                for (let i = 0; i < prize.count; i++) {
                    result.push(data[i] || null);
                }

                return result;
            },

            getPrizeNumbersXSTN(prize, lottery) {
                const safeLottery = lottery ?? {};
                const data = safeLottery[prize.key] || [];
                const result = [];

                for (let i = 0; i < prize.count; i++) {
                    result.push(
                        prize.key === 'province'
                            ? (data ?? null)
                            : (Array.isArray(data) ? (data[i] ?? null) : null)
                    );
                }
                return result;
            },

            getLotoByHead(lottery, head) {
                return lottery?.map((item, index) => ({ item, index }))
                    .filter(({ item }) => item.charAt(0) == head);
            },

            toggleNumber(number) {
                const index = this.data.selectedNumbers.indexOf(number);
                if (index > -1) {
                    this.data.selectedNumbers.splice(index, 1);
                } else {
                    this.data.selectedNumbers.push(number);
                }
                this.renderHeatmap();
            },

            formatNumber(num) {
                return num.toString().padStart(2, '0');
            },

            formatDate(date) {
                return new Date(date).toLocaleDateString('vi-VN');
            },

            formatDateLong(dateString) {
                return new Date(dateString).toLocaleDateString('vi-VN', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
            },

            openHistoryModal() {
                this.data.showHistoryModal = true;
                document.getElementById('history-modal').classList.remove('hidden');
                this.renderHistoryModal();
            },

            closeHistoryModal() {
                this.data.showHistoryModal = false;
                document.getElementById('history-modal').classList.add('hidden');
            },

            showToast(message, type = 'info') {
                const toast = {
                    id: ++this.data.toastId,
                    message,
                    type
                };
                this.data.toasts.push(toast);
                this.renderToasts();
                setTimeout(() => this.removeToast(toast.id), 5000);
            },

            removeToast(id) {
                const index = this.data.toasts.findIndex(toast => toast.id === id);
                if (index > -1) {
                    this.data.toasts.splice(index, 1);
                    this.renderToasts();
                }
            },

            renderTickerContent() {
                const content = document.getElementById('ticker-content');
                content.innerHTML = '';
                const lotteryTitle = {
                    XSMB: 'XSMB - Kết quả xổ số miền Bắc',
                    XSMN: 'XSMN - Kết quả xổ số miền Nam',
                    XSMT: 'XSMT - Kết quả xổ số miền Trung'
                }[this.data.region] || 'Kết quả xổ số';

                let html = `
                    <div class="container" id="lottery-result">
                        <div class="breadcrumb">
                            <a href="#" class="text-blue-600">${lotteryTitle} - ${this.formatDate(this.data.currentDate)}</a>
                        </div>
                `;

                if (this.data.filters.region === 'XSMB') {
                    html += `
                        <table class="results-table w-full text-left">
                            ${this.prizeStructure.XSMB.map(prize => `
                                <tr>
                                    <td class="prize-code py-2 pr-4">${prize.code}</td>
                                    <td class="prize-numbers ${prize.gridClass}">
                                        ${this.getPrizeNumbers(prize).map(number => `
                                            <div class="number ${prize.className}">
                                                ${number ? number : '<div class="loading-number"></div>'}
                                            </div>
                                        `).join('')}
                                    </td>
                                </tr>
                            `).join('')}
                        </table>
                    </div>
                    <div>
                        <div id="lottery-result-statis">
                            <div class="region-result">
                                <div class="region-title text-lg font-semibold">Tổng hợp loto - ${this.formatDate(this.data.currentDate)}</div>
                                ${Array.from({ length: 10 }, (_, i) => `
                                    <div class="result-numbers flex gap-2 my-2">
                                        <div>Đầu ${i}: </div>
                                        ${this.getLotoByHead(this.data.lotoNumbersXSMB, i).map(({ item, index }) => `
                                            <div class="number-ball p-2 bg-gray-100 rounded ${index === 26 ? 'bg-red text-white' : ''}">
                                                ${item}
                                            </div>
                                        `).join('')}
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    `;
                }else{
                    html +=`
                        <table class="results-table w-full text-left">
                            ${this.prizeStructure.XSTN.map(prize => `
                                <tr>
                                    <td class="prize-code py-2 pr-4">${prize.code}</td>
                                    ${Object.values(this.data.lotteryXSTN).map(lottery =>`
                                        <td class="prize-numbers">
                                            ${this.getPrizeNumbersXSTN(prize, lottery.lottery).map(number => `
                                                <div class="number ${prize.className} w-full">
                                                    ${number ? number : '<div class="loading-number"></div>'}
                                                </div>
                                            `).join('')}
                                        </td>
                                    `).join('')}
                                </tr>
                            `).join('')}
                        </table>

                    </div>
                    <div>
                        ${Object.values(this.data.lotteryXSTN).map(it => `
                            <div class="lottery-result-statis" data-province="${it.lottery?.province ?? ''}">
                                <div class="region-result">
                                    <div class="region-title text-lg font-semibold">Tổng hợp loto - ${it.lottery?.province ?? 'Chưa xác định'} - ${this.formatDate(this.data.currentDate)}</div>
                                    ${Array.from({ length: 10 }, (_, i) => `
                                        <div class="result-numbers flex gap-2 my-2">
                                            <div>Đầu ${i}: </div>
                                            ${this.getLotoByHead(it.loto ,i)? this.getLotoByHead(it.loto ,i).map(({ item, index }) => `
                                                <div class="number-ball p-2 bg-gray-100 rounded ${index === 17 ? 'bg-red text-white' : ''}">
                                                    ${item ?? ''}
                                                </div>
                                            `).join('') : ''}
                                        </div>
                                    `).join('')}
                                </div>
                            </div>
                        `)}
                    `;
                }

                html += `
                        <div class="predictions mt-4">
                            <h3 class="mb-3 text-lg font-semibold"><i class="fas fa-robot"></i> Dự đoán AI cho lần quay tiếp theo</h3>
                            <div class="prediction-cards grid grid-cols-1 sm:grid-cols-2 gap-4">
                                ${this.data.aiPredictions.map(prediction => `
                                    <div class="prediction-card p-4 bg-gray-50 rounded shadow">
                                        <div class="prediction-title font-medium">${prediction.title}</div>
                                        <div class="prediction-numbers flex gap-2 my-2">
                                            ${prediction.numbers.map(number => `
                                                <div class="number-ball p-2 bg-gray-100 rounded" style="${prediction.style ? `font-size:${prediction.style.fontSize}` : ''}">
                                                    ${number}
                                                </div>
                                            `).join('')}
                                        </div>
                                        <div class="confidence-bar h-2 bg-gray-200 rounded">
                                            <div class="confidence-fill h-2 bg-blue-500 rounded" style="width:${prediction.confidence}%"></div>
                                        </div>
                                        <small>Độ tin cậy: ${prediction.confidence}%</small>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    </div>
                `;

                content.innerHTML = html;
            },

            renderQuickStats() {
                const stats = document.getElementById('quick-stats');
                stats.innerHTML = `
                    <div class="stat-card p-4 bg-gray-50 rounded shadow text-center">
                        <div class="stat-number text-2xl font-bold">${this.data.aiStats.accuracy_percent}%</div>
                        <div class="stat-label">Độ chính xác của AI</div>
                    </div>
                    <div class="stat-card p-4 bg-gray-50 rounded shadow text-center">
                        <div class="stat-number text-2xl font-bold">${this.data.aiStats.latest_hit?.date || 'N/A'}</div>
                        <div class="stat-label">Ngày đoán đúng gần nhất</div>
                    </div>
                    <div class="stat-card p-4 bg-gray-50 rounded shadow text-center">
                        <div class="stat-number text-2xl font-bold">${this.data.aiStats.max_streak || 0}</div>
                        <div class="stat-label">Chuỗi ngày đoán đúng liên tiếp</div>
                    </div>
                    <div class="stat-card p-4 bg-gray-50 rounded shadow text-center">
                        <div class="stat-number">
                            <button id="open-history-modal" class="cursor-pointer"><i class="fas fa-eye"></i></button>
                        </div>
                        <div class="stat-label">Lịch sử dự đoán</div>
                    </div>
                `;
                document.getElementById('open-history-modal').addEventListener('click', () => this.openHistoryModal());
            },

            renderHeatmap() {
                const heatmap = document.getElementById('heatmap-grid');
                heatmap.innerHTML = '';
                for (let i = 0; i < 100; i++) {
                    const number = this.formatNumber(i);
                    const cell = document.createElement('div');
                    cell.className = `heatmap-cell cursor-pointer p-2 text-center rounded ${this.data.selectedNumbers.includes(number) ? 'selected' : ''}`;
                    cell.textContent = number;
                    cell.addEventListener('click', () => this.toggleNumber(number));
                    heatmap.appendChild(cell);
                }
            },

            renderHistoryModal() {
                const content = document.getElementById('history-content');
                content.innerHTML = this.data.predictionHistory.map((item, index) => `
                    <div class="border rounded-lg p-6 mb-4 transition-all hover:shadow-md ${item.hit > 0 ? 'border-green-200 bg-green-50' : 'border-gray-200 bg-white'}">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-4">
                            <div class="flex items-center mb-2 lg:mb-0">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                    <span class="text-blue-600 font-bold text-lg">${index + 1}</span>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900">${this.formatDateLong(item.date)}</h4>
                                    <p class="text-sm text-gray-500">Ngày quay: ${item.date}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${item.hit > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                                    ${item.hit > 0 ? 'Dự đoán đúng' : 'Dự đoán sai'}
                                </span>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-700">Giải đặc biệt:</span>
                                    <span class="text-lg font-bold text-red-600">${item.special_prize}</span>
                                </div>
                            </div>
                            <div>
                                <h5 class="text-sm font-medium text-gray-700 mb-2">Dự đoán 2 số cuối của AI:</h5>
                                <div class="grid grid-cols-5 gap-2">
                                    ${item.predicted.map(num => `
                                        <div class="w-10 h-10 rounded-lg flex items-center justify-center text-sm font-bold ${num === item.tail ? 'bg-green-500 text-white ring-2 ring-green-300' : 'bg-gray-100 text-gray-700'}">
                                            ${num}
                                        </div>
                                    `).join('')}
                                </div>
                                ${item.hit > 0 ? `<p class="text-xs text-green-600 mt-2 font-medium">✓ Số đúng: ${item.predicted.filter(num => num === item.tail).join(', ')}</p>` : ''}
                            </div>
                        </div>
                    </div>
                `).join('');
            },

            renderToasts() {
                const container = document.getElementById('toastContainer');
                container.innerHTML = this.data.toasts.map(toast => `
                    <div class="toast ${toast.type} p-4 bg-${toast.type === 'error' ? 'red' : 'blue'}-500 text-white rounded shadow cursor-pointer" onclick="app.removeToast(${toast.id})">
                        ${toast.message}
                    </div>
                `).join('');
            },

            initializeCharts() {
                this.createFrequencyChart();
                this.createTrendChart();
                this.createGapChart();
            },

            createFrequencyChart() {
                const canvas = document.getElementById('frequencyChart');
                if (!canvas) return;
                const ctx = canvas.getContext('2d');
                const stats = this.data.chartData.specialPrizeStats || [];
                const labels = this.data.selectedNumbers.length > 0 ? this.data.selectedNumbers : stats.map(item => item.loto_number);
                const freqData = [];
                const drawDates = [];
                labels.forEach(number => {
                    const stat = stats.find(item => item.loto_number == number);
                    freqData.push(stat ? stat.frequency : 0);
                    drawDates.push(stat ? stat.draw_dates : '');
                });
                if (this.data.charts.frequency) {
                    this.data.charts.frequency.destroy();
                }
                this.data.charts.frequency = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels,
                        datasets: [{
                            label: 'Tần suất xuất hiện',
                            data: freqData,
                            backgroundColor: '#99cccc82',
                            borderColor: '#9cc',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { labels: { color: 'black' } },
                            tooltip: {
                                callbacks: {
                                    afterBody: (context) => {
                                        const index = context[0].dataIndex;
                                        const dates = drawDates[index]?.split(',').join(', ');
                                        return dates ? 'Ngày xuất hiện: ' + dates : 'Không có dữ liệu';
                                    }
                                }
                            }
                        },
                        scales: {
                            y: { beginAtZero: true, ticks: { color: 'black' }, grid: { color: 'rgba(0,0,0,0.1)' } },
                            x: { ticks: { color: 'black' }, grid: { color: 'rgba(0,0,0,0.1)' } }
                        }
                    }
                });
            },

            createTrendChart() {
                const canvas = document.getElementById('trendChart');
                if (!canvas) return;
                const ctx = canvas.getContext('2d');
                const stats = this.data.chartData.allNumberStats || [];
                const labels = this.data.selectedNumbers.length > 0 ? this.data.selectedNumbers : stats.map(item => item.loto_number);
                const freqData = [];
                const drawDates = [];
                labels.forEach(number => {
                    const stat = stats.find(item => item.loto_number == number);
                    freqData.push(stat ? stat.frequency : 0);
                    drawDates.push(stat ? stat.draw_dates : '');
                });
                if (this.data.charts.trend) {
                    this.data.charts.trend.destroy();
                }
                this.data.charts.trend = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels,
                        datasets: [{
                            label: 'Số lần xuất hiện',
                            data: freqData,
                            backgroundColor: 'rgba(72, 187, 120, 0.6)',
                            borderColor: '#48bb78',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { labels: { color: 'black' } },
                            tooltip: {
                                callbacks: {
                                    afterBody: (context) => {
                                        const index = context[0].dataIndex;
                                        const dates = drawDates[index]?.split(',').join('\n');
                                        return 'Ngày xuất hiện:\n' + dates;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: { beginAtZero: true, ticks: { color: 'black' }, grid: { color: 'rgba(0,0,0,0.1)' } },
                            y: { ticks: { color: 'black' }, grid: { color: 'rgba(0,0,0,0.1)' } }
                        }
                    }
                });
            },

            createGapChart() {
                const canvas = document.getElementById('gapChart');
                if (!canvas) return;
                const ctx = canvas.getContext('2d');
                const stats = this.data.chartData.lastAppearanceRecords || [];
                const labels = this.data.selectedNumbers.length > 0 ? this.data.selectedNumbers : stats.map(item => item.loto_number);
                const daysData = [];
                const lastDrawDate = [];
                labels.forEach(number => {
                    const stat = stats.find(item => item.loto_number == number);
                    daysData.push(stat ? stat.days_not_appeared : 0);
                    lastDrawDate.push(stat ? stat.last_draw_date : '');
                });
                if (this.data.charts.gap) {
                    this.data.charts.gap.destroy();
                }
                this.data.charts.gap = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels,
                        datasets: [{
                            label: 'Số ngày chưa xuất hiện',
                            data: daysData,
                            backgroundColor: 'rgba(245, 101, 101, 0.2)',
                            borderColor: '#f56565',
                            tension: 0.3,
                            fill: true
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { labels: { color: 'black' } },
                            tooltip: {
                                callbacks: {
                                    afterBody: (context) => {
                                        const index = context[0].dataIndex;
                                        const date = lastDrawDate[index] || 'Không rõ';
                                        return 'Ngày ra gần nhất: ' + date;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: { beginAtZero: true, ticks: { color: 'black' }, grid: { color: 'rgba(0,0,0,0.1)' } },
                            x: { ticks: { color: 'black' }, grid: { color: 'rgba(0,0,0,0.1)' } }
                        }
                    }
                });
            },

            setupSocketConnection() {
                if (window.Echo) {
                    window.Echo.channel('lottery-result')
                        .listen('.lottery.sent', (e) => {
                            const data = {};
                            const region = this.data.filters.region;

                            e.forEach(item => {
                                if (item.region === region) {
                                    if (region === 'XSMB') {
                                        this.handleSocketData(item.prizes);
                                    } else {
                                        data[item.province] = item.prizes;
                                    }
                                }
                            });

                            if (region !== 'XSMB' && Object.keys(data).length > 0) {
                                this.handleSocketData(data);
                            }

                        });
                }
            },

            handleSocketData(data) {
                this.data.lotteryDrawing.onSocketData(data);
                // this.renderTickerContent();
            },

            async initLotteryDrawing(type, date, stations = []) {
                this.data.lotteryDrawing = window.createLotterySystem(type);
                await this.data.lotteryDrawing.init(date, stations);
            }
        };

        document.addEventListener('DOMContentLoaded', () => app.init());
    </script>
@endsection
