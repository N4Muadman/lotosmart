@extends('layout')

@section('content')
    <div id="vue-component">
        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-content fade-in">
                <h1>Phân tích thông minh<br>Quyết định sáng suốt</h1>
                <p>Hệ thống phân tích lô đề tiên tiến nhất với AI và Machine Learning, giúp bạn đưa ra quyết định dựa
                    trên dữ liệu chính xác.</p>
                <div class="cta-buttons">
                    <a href="#dashboard" class="btn btn-primary">Bắt đầu miễn phí</a>
                    <a href="#demo" class="btn btn-secondary">Xem demo</a>
                </div>
            </div>
        </section>

        <div class="container mx-auto">
            <section class="live-ticker slide-in">
                <div class="grid grid-cols-1 md:grid-cols-2 pb-3">
                    <div class="ticker-header">
                        <div class="live-indicator"></div>
                        <h3><i class="fas fa-broadcast-tower"></i> Kết quả trực tiếp</h3>
                        <span class="loading" v-if="loading"></span>
                    </div>
                    <div class="flex justify-end gap-4">
                        <input type="date" v-model="filters.date" @change="LotteryFilter" class="filter-input">
                        <select v-model="filters.region" @change="LotteryFilter" class="filter-input text-black">
                            <option value="XSMB">Miền bắc</option>
                            <option value="XSMT">Miền Trung</option>
                            <option value="XSMN">Miền Nam</option>
                        </select>
                    </div>
                </div>

                <div class="ticker-content grid grid-cols-1 md:grid-cols-2 gap-4" v-if="filters.region == 'XSMB'">
                    <!-- Lottery Results -->
                    <div class="container" id="lottery-result">
                        <div class="breadcrumb">
                            <a href="#">@{{ lotteryTitle }} - @{{ formatDate(currentDate) }}</a>
                        </div>

                        <table class="results-table">
                            <tr v-for="prize in prizeStructure" :key="prize.code">
                                <td class="prize-code">@{{ prize.code }}</td>
                                <td class="prize-numbers" :class="prize.gridClass">
                                    <div v-for="(number, index) in getPrizeNumbers(prize)" :key="index"
                                        :class="['number', prize.className]">
                                        <div v-if="!number" class="loading-number"></div>
                                        <template v-else>@{{ number }}</template>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Statistics and AI Predictions -->
                    <div>
                        <div id="lottery-result-statis">
                            <div class="region-result">
                                <div class="region-title">Tổng hợp loto - @{{ formatDate(currentDate) }}</div>
                                <div v-for="i in 10" :key="i" class="result-numbers">
                                    <div>Đầu @{{ i - 1 }}: </div>
                                    <div v-for="({ item, index }, i) in getLotoByHead(i - 1)" :key="index"
                                        :class="['number-ball', { 'bg-red': index === 26 }]">
                                        @{{ item }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- AI Predictions -->
                        <div class="predictions">
                            <h3 class="mb-3"><i class="fas fa-robot"></i> Dự đoán AI cho lần quay tiếp theo</h3>
                            <div class="prediction-cards">
                                <div v-for="prediction in aiPredictions" :key="prediction.title" class="prediction-card">
                                    <div class="prediction-title">@{{ prediction.title }}</div>
                                    <div class="prediction-numbers">
                                        <div v-for="number in prediction.numbers" :key="number" class="number-ball"
                                            :style="prediction.style">
                                            @{{ number }}
                                        </div>
                                    </div>
                                    <div class="confidence-bar">
                                        <div class="confidence-fill" :style="`width: ${prediction.confidence}%`"></div>
                                    </div>
                                    <small>Độ tin cậy: @{{ prediction.confidence }}%</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ticker-content grid grid-cols-1 md:grid-cols-2 gap-4" v-else>
                    <!-- Lottery Results -->
                    <div class="container" id="lottery-result">
                        <div class="breadcrumb">
                            <a href="#">@{{ lotteryTitle }} - @{{ formatDate(currentDate) }}</a>
                        </div>

                        {{-- <table class="results-table">
                            <tr v-for="prize in prizeStructure" :key="prize.code">
                                <td class="prize-code">@{{ prize.code }}</td>
                                <td class="prize-numbers" :class="prize.gridClass">
                                    <div v-for="(number, index) in getPrizeNumbers(prize)" :key="index"
                                        :class="['number', prize.className]">
                                        <div v-if="!number" class="loading-number"></div>
                                        <template v-else>@{{ number }}</template>
                                    </div>
                                </td>
                            </tr>
                        </table> --}}
                    </div>

                    <!-- Statistics and AI Predictions -->
                    <div>
                        <div id="lottery-result-statis">
                            <div class="region-result">
                                <div class="region-title">Tổng hợp loto - @{{ formatDate(currentDate) }}</div>
                                <div v-for="i in 10" :key="i" class="result-numbers">
                                    <div>Đầu @{{ i - 1 }}: </div>
                                    <div v-for="({ item, index }, i) in getLotoByHead(i - 1)" :key="index"
                                        :class="['number-ball', { 'bg-red': index === 26 }]">
                                        @{{ item }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- AI Predictions -->
                        <div class="predictions">
                            <h3 class="mb-3"><i class="fas fa-robot"></i> Dự đoán AI cho lần quay tiếp theo</h3>
                            <div class="prediction-cards">
                                <div v-for="prediction in aiPredictions" :key="prediction.title" class="prediction-card">
                                    <div class="prediction-title">@{{ prediction.title }}</div>
                                    <div class="prediction-numbers">
                                        <div v-for="number in prediction.numbers" :key="number"
                                            class="number-ball" :style="prediction.style">
                                            @{{ number }}
                                        </div>
                                    </div>
                                    <div class="confidence-bar">
                                        <div class="confidence-fill" :style="`width: ${prediction.confidence}%`"></div>
                                    </div>
                                    <small>Độ tin cậy: @{{ prediction.confidence }}%</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="mt-3">
                    <h3 class="mb-3"><i class="fas fa-robot"></i> Lịch sử dự đoán giải đặc biệt (10 số/ngày) của AI và kết
                        quả đối chiếu thực tế cách đây 10 ngày</h3>
                    <div class="quick-stats">
                        <div class="stat-card">
                            <div class="stat-number">@{{ aiStats.accuracy_percent }}%</div>
                            <div class="stat-label">Độ chính xác của AI</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number"><span class="text-3xl">@{{ aiStats.latest_hit?.date || 'N/A' }}</span></div>
                            <div class="stat-label">Ngày đoán đúng gần nhất</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">@{{ aiStats.max_streak || 0 }}</div>
                            <div class="stat-label">Chuỗi ngày đoán đúng liên tiếp</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-number">
                                <button class="cursor-pointer" @click="openHistoryModal">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="stat-label">Lịch sử dự đoán</div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="dashboard" class="dashboard">
                <h2 class="section-title">Thống kê kết quả</h2>

                <!-- Analysis Tools -->
                <div class="analysis-tools">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="dashboard-card mx-auto">
                            <div class="card-header">
                                <h3 class="card-title">Chọn số để thống kê</h3>
                            </div>
                            <div class="heatmap-container">
                                <div class="heatmap-grid">
                                    <div v-for="i in 100" :key="i" class="heatmap-cell"
                                        :class="{ 'selected': selectedNumbers.includes(formatNumber(i - 1)) }"
                                        @click="toggleNumber(formatNumber(i-1))">
                                        @{{ formatNumber(i - 1) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <form @submit.prevent="submitStatistics">
                            <div class="tool-filters">
                                <div class="filter-group">
                                    <label class="filter-label">Biên độ</label>
                                    <select v-model="statisticsForm.days_period" class="filter-input">
                                        <option value="7">7 ngày qua</option>
                                        <option value="30">30 ngày qua</option>
                                        <option value="45">45 ngày qua</option>
                                        <option value="60">60 ngày qua</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <label class="filter-label">Miền</label>
                                    <select v-model="statisticsForm.region" class="filter-input">
                                        <option value="XSMB">Miền Bắc</option>
                                        <option value="XSMT">Miền Trung</option>
                                        <option value="XSMN">Miền Nam</option>
                                    </select>
                                </div>
                                <div class="filter-group">
                                    <label class="filter-label">Ngày thống kê</label>
                                    <input type="date" v-model="statisticsForm.date" class="filter-input">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" :disabled="submitting">
                                @{{ submitting ? 'Đang xử lý...' : 'Áp dụng bộ lọc' }}
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Dashboard Grid -->
                <div class="dashboard-grid">
                    <div class="dashboard-card">
                        <div class="card-header">
                            <h3 class="card-title">Thống kê số lần ra của giải đặc biệt</h3>
                            <i class="fas fa-chart-bar card-icon"></i>
                        </div>
                        <div class="chart-container">
                            <canvas ref="frequencyChart"></canvas>
                        </div>
                    </div>

                    <div class="dashboard-card">
                        <div class="card-header">
                            <h3 class="card-title">Thống kê số lần ra của tất cả giải</h3>
                            <i class="fas fa-chart-bar card-icon"></i>
                        </div>
                        <div class="chart-container">
                            <canvas ref="trendChart"></canvas>
                        </div>
                    </div>

                    <div class="dashboard-card">
                        <div class="card-header">
                            <h3 class="card-title">Thống kê số ngày chưa ra</h3>
                            <i class="fas fa-chart-line card-icon"></i>
                        </div>
                        <div class="chart-container">
                            <canvas ref="gapChart"></canvas>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- History Modal -->
        <div v-if="showHistoryModal" class="relative z-10" @click="closeHistoryModal" v-cloak>
            <div class="fixed inset-0 bg-gray-500/75 transition-opacity"></div>
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4">
                    <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all w-full max-w-6xl"
                        @click.stop>
                        <!-- Modal content -->
                        <div class="header-background-modal px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div
                                        class="flex-shrink-0 w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-semibold text-white">Lịch Sử Dự Đoán AI</h3>
                                        <p class="text-blue-100 text-sm">Kết quả dự đoán 10 ngày gần nhất</p>
                                    </div>
                                </div>
                                <button @click="closeHistoryModal"
                                    class="text-white/80 hover:text-white transition-colors">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="max-h-[70vh] overflow-y-auto">
                            <div class="p-6">
                                <div class="space-y-6">
                                    <div v-for="(item, index) in predictionHistory" :key="index"
                                        :class="['border rounded-lg p-6 transition-all hover:shadow-md',
                                            item.hit > 0 ? 'border-green-200 bg-green-50' : 'border-gray-200 bg-white'
                                        ]">
                                        <!-- History item content -->
                                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-4">
                                            <div class="flex items-center mb-2 lg:mb-0">
                                                <div
                                                    class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                                    <span
                                                        class="text-blue-600 font-bold text-lg">@{{ index + 1 }}</span>
                                                </div>
                                                <div>
                                                    <h4 class="text-lg font-semibold text-gray-900">@{{ formatDateLong(item.date) }}
                                                    </h4>
                                                    <p class="text-sm text-gray-500">Ngày quay: @{{ item.date }}</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center space-x-3">
                                                <span
                                                    :class="['inline-flex items-center px-3 py-1 rounded-full text-sm font-medium',
                                                        item.hit > 0 ? 'bg-green-100 text-green-800' :
                                                        'bg-red-100 text-red-800'
                                                    ]">
                                                    @{{ item.hit > 0 ? 'Dự đoán đúng' : 'Dự đoán sai' }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                            <div class="space-y-3">
                                                <div class="flex items-center justify-between">
                                                    <span class="text-sm font-medium text-gray-700">Giải đặc biệt:</span>
                                                    <span
                                                        class="text-lg font-bold text-red-600">@{{ item.special_prize }}</span>
                                                </div>
                                            </div>

                                            <div>
                                                <h5 class="text-sm font-medium text-gray-700 mb-2">Dự đoán 2 số cuối của
                                                    AI:</h5>
                                                <div class="grid grid-cols-5 gap-2">
                                                    <div v-for="num in item.predicted" :key="num"
                                                        :class="['w-10 h-10 rounded-lg flex items-center justify-center text-sm font-bold',
                                                            num === item.tail ?
                                                            'bg-green-500 text-white ring-2 ring-green-300' :
                                                            'bg-gray-100 text-gray-700'
                                                        ]">
                                                        @{{ num }}
                                                    </div>
                                                </div>
                                                <p v-if="item.hit > 0" class="text-xs text-green-600 mt-2 font-medium">
                                                    ✓ Số đúng: @{{ item.predicted.filter(num => num === item.tail).join(', ') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 px-6 py-4 border-t">
                            <div class="flex justify-between items-center">
                                <button @click="closeHistoryModal"
                                    class="btn-close inline-flex items-center px-3 py-2 text-sm rounded-md bg-primary-gradient color-muted">
                                    Đóng
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Toast Container -->
        <div id="toastContainer" class="toast-container">
            <div v-for="toast in toasts" :key="toast.id" :class="['toast', toast.type]"
                @click="removeToast(toast.id)">
                @{{ toast.message }}
            </div>
        </div>
    </div>

    <script type="module">
        const lotteryApp = {
            data() {
                return {
                    loading: false,
                    submitting: false,
                    showHistoryModal: false,

                    // Filters
                    filters: {
                        date: '',
                        region: 'XSMB'
                    },

                    // Statistics form
                    statisticsForm: {
                        days_period: '30',
                        region: 'XSMB',
                        date: ''
                    },

                    // Lottery data
                    lotteryData: {},
                    lotoNumbers: [],
                    currentDate: new Date(),
                    region: 'XSMB',

                    // AI data
                    aiStats: {
                        accuracy_percent: 0,
                        latest_hit: null,
                        max_streak: 0
                    },
                    predictionHistory: [],

                    // Heatmap
                    selectedNumbers: [],

                    lotteryDrawing: null,

                    // Charts
                    charts: {
                        frequency: null,
                        trend: null,
                        gap: null
                    },

                    // Chart data
                    chartData: {
                        specialPrizeStats: [],
                        allNumberStats: [],
                        lastAppearanceRecords: []
                    },

                    // Toasts
                    toasts: [],
                    toastId: 0,

                    // AI Predictions (static data)
                    aiPredictions: [{
                            title: 'Bạch thủ lô XSMB',
                            numbers: [47],
                            confidence: 87
                        },
                        {
                            title: 'Song thủ lô',
                            numbers: [23, 78],
                            confidence: 74
                        },
                        {
                            title: '3 càng',
                            numbers: [5, 6, 7],
                            confidence: 65
                        },
                        {
                            title: 'Dàn đề 10 số',
                            numbers: [12, 90, 34, 56, 78],
                            confidence: 82,
                            style: {
                                fontSize: '0.7rem'
                            }
                        }
                    ]
                }
            },

            computed: {
                lotteryTitle() {
                    const titles = {
                        XSMB: 'XSMB - Kết quả xổ số miền Bắc',
                        XSMN: 'XSMN - Kết quả xổ số miền Nam',
                        XSMT: 'XSMT - Kết quả xổ số miền Trung',
                    };
                    return titles[this.region] || 'Kết quả xổ số';
                },

                prizeStructure() {
                    return [{
                            code: 'Mã ĐB',
                            key: 'special_code',
                            gridClass: 'grid grid-cols-6',
                            className: 'date-codes',
                            count: 6
                        },
                        {
                            code: 'G.ĐB',
                            key: 'special_prize',
                            gridClass: 'grid grid-cols-1',
                            className: 'special-prize',
                            count: 1
                        },
                        {
                            code: 'G.1',
                            key: 'first_prize',
                            gridClass: 'grid grid-cols-1',
                            className: '',
                            count: 1
                        },
                        {
                            code: 'G.2',
                            key: 'second_prize',
                            gridClass: 'grid grid-cols-2',
                            className: '',
                            count: 2
                        },
                        {
                            code: 'G.3',
                            key: 'third_prize',
                            gridClass: 'grid grid-cols-3',
                            className: '',
                            count: 6
                        },
                        {
                            code: 'G.4',
                            key: 'fourth_prize',
                            gridClass: 'grid grid-cols-2 md:grid-cols-4',
                            className: '',
                            count: 4
                        },
                        {
                            code: 'G.5',
                            key: 'fifth_prize',
                            gridClass: 'grid grid-cols-3',
                            className: '',
                            count: 6
                        },
                        {
                            code: 'G.6',
                            key: 'sixth_prize',
                            gridClass: 'grid grid-cols-3',
                            className: '',
                            count: 3
                        },
                        {
                            code: 'G.7',
                            key: 'seventh_prize',
                            gridClass: 'grid grid-cols-4',
                            className: 'last-two',
                            count: 4
                        }
                    ];
                }
            },

            async mounted() {
                this.setupSocketConnection();
                await this.initializeData();
                await this.$nextTick();
            },

            beforeUnmount() {
                Object.values(this.charts).forEach(chart => {
                    if (chart) {
                        chart.destroy();
                    }
                });
            },

            methods: {
                async initializeData() {
                    await Promise.all([
                        this.fetchLotteryResult(),
                        this.fetchAiPredictionData(),
                        this.fetchStatisticsData(),
                        this.initLotteryDrawing('XSMB', this.filters.date),
                    ]);
                },

                async fetchLotteryResult() {
                    this.loading = true;
                    try {
                        const params = new URLSearchParams({
                            date: this.filters.date,
                            region: this.filters.region
                        });

                        const response = await fetch(`{{ config('api_endpoint.get_lottery_result') }}?${params}`, {
                            headers: {
                                'Accept': 'application/json'
                            }
                        });

                        if (!response.ok) throw new Error('Failed to fetch lottery data');

                        const data = await response.json();
                        this.lotteryData = data.lottery || {};
                        this.lotoNumbers = Object.values(data.loto || {});
                        this.currentDate = data.date || new Date();
                        this.region = data.region || 'XSMB';
                    } catch (error) {
                        this.showToast('Có lỗi xảy ra khi lấy dữ liệu xổ số', 'error');
                        console.error(error);
                    } finally {
                        this.loading = false;
                    }
                },

                async fetchAiPredictionData() {
                    try {
                        const response = await fetch(`{{ config('api_endpoint.ai_prediction_special_prize') }}`, {
                            headers: {
                                'Accept': 'application/json'
                            }
                        });

                        if (!response.ok) throw new Error('Failed to fetch AI prediction data');

                        const data = await response.json();
                        this.aiStats = {
                            accuracy_percent: data.accuracy_percent || 0,
                            latest_hit: data.latest_hit || null,
                            max_streak: data.max_streak || 0
                        };
                        this.predictionHistory = Object.values(data.stats || {});
                    } catch (error) {
                        this.showToast('Không thể tải dữ liệu dự đoán AI', 'error');
                        console.error(error);
                    }
                },

                async fetchStatisticsData() {
                    this.submitting = true;
                    try {
                        const params = new URLSearchParams({
                            numbers: this.selectedNumbers.join(','),
                            date: this.statisticsForm.date,
                            days_period: this.statisticsForm.days_period,
                            region: this.statisticsForm.region
                        });

                        const response = await fetch(`{{ config('api_endpoint.base_statis') }}?${params}`, {
                            headers: {
                                'Accept': 'application/json'
                            }
                        });

                        if (!response.ok) throw new Error('Failed to fetch statistics data');

                        const data = await response.json();

                        this.updateCharts(data.special_prize_stats, data.all_number_stats, data
                            .lastAppearanceRecords);
                    } catch (error) {
                        this.showToast('Có lỗi xảy ra khi lấy dữ liệu thống kê', 'error');
                        console.error(error);
                    } finally {
                        this.submitting = false;
                    }
                },

                async submitStatistics() {
                    await this.fetchStatisticsData();
                },

                async LotteryFilter() {
                        console.log('dang 1 chay');

                    if (this.lotteryDrawing?.isDrawing) {
                        console.log('dang chay');

                        this.lotteryDrawing.stopAllDrawings();
                    }

                    await this.fetchLotteryResult();

                    this.initLotteryDrawing(this.filters.region, this.filters.date);
                },

                getPrizeNumbers(prize) {
                    const data = this.lotteryData[prize.key] || [];
                    const result = [];
                    for (let i = 0; i < prize.count; i++) {
                        result.push(data[i] || null);
                    }
                    return result;
                },

                getLotoByHead(head) {
                    return this.lotoNumbers
                        .map((item, index) => ({
                            item,
                            index
                        }))
                        .filter(({
                            item
                        }) => item.charAt(0) == head);
                },

                toggleNumber(number) {
                    const index = this.selectedNumbers.indexOf(number);
                    if (index > -1) {
                        this.selectedNumbers.splice(index, 1);
                    } else {
                        this.selectedNumbers.push(number);
                    }
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
                    this.showHistoryModal = true;
                },

                closeHistoryModal() {
                    this.showHistoryModal = false;
                },

                showToast(message, type = 'info') {
                    const toast = {
                        id: ++this.toastId,
                        message,
                        type
                    };
                    this.toasts.push(toast);

                    setTimeout(() => {
                        this.removeToast(toast.id);
                    }, 5000);
                },

                removeToast(id) {
                    const index = this.toasts.findIndex(toast => toast.id === id);
                    if (index > -1) {
                        this.toasts.splice(index, 1);
                    }
                },

                initializeCharts() {
                    this.$nextTick(() => {

                        this.createFrequencyChart();
                        this.createTrendChart();
                        this.createGapChart();
                    });
                },

                createFrequencyChart() {
                    const canvas = this.$refs.frequencyChart;
                    if (!canvas) return;

                    const ctx = canvas.getContext('2d');
                    const stats = this.chartData.specialPrizeStats || [];

                    const labels = this.selectedNumbers.length > 0 ?
                        this.selectedNumbers :
                        stats.map(item => item.loto_number);

                    const freqData = [];
                    const drawDates = [];

                    labels.forEach(number => {
                        const stat = stats.find(item => item.loto_number == number);
                        if (stat) {
                            freqData.push(stat.frequency);
                            drawDates.push(stat.draw_dates);
                        } else {
                            freqData.push(0);
                            drawDates.push('');
                        }
                    });

                    if (this.charts.frequency) {
                        this.charts.frequency.destroy();
                    }

                    this.charts.frequency = new Chart(ctx, {
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
                                legend: {
                                    labels: {
                                        color: 'white'
                                    }
                                },
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
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        color: 'white'
                                    },
                                    grid: {
                                        color: 'rgba(255,255,255,0.1)'
                                    }
                                },
                                x: {
                                    ticks: {
                                        color: 'white'
                                    },
                                    grid: {
                                        color: 'rgba(255,255,255,0.1)'
                                    }
                                }
                            }
                        }
                    });
                },

                createTrendChart() {
                    const canvas = this.$refs.trendChart;

                    if (!canvas) return;

                    const ctx = canvas.getContext('2d');
                    const stats = this.chartData.allNumberStats || [];

                    const labels = this.selectedNumbers.length > 0 ?
                        this.selectedNumbers :
                        stats.map(item => item.loto_number);

                    const freqData = [];
                    const drawDates = [];

                    labels.forEach(number => {
                        const stat = stats.find(item => item.loto_number == number);
                        if (stat) {
                            freqData.push(stat.frequency);
                            drawDates.push(stat.draw_dates);
                        } else {
                            freqData.push(0);
                            drawDates.push('');
                        }
                    });

                    if (this.charts.trend) {
                        this.charts.trend.destroy();
                    }

                    this.charts.trend = new Chart(ctx, {
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
                                legend: {
                                    labels: {
                                        color: 'white'
                                    }
                                },
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
                                x: {
                                    beginAtZero: true,
                                    ticks: {
                                        color: 'white'
                                    },
                                    grid: {
                                        color: 'rgba(255,255,255,0.1)'
                                    }
                                },
                                y: {
                                    ticks: {
                                        color: 'white'
                                    },
                                    grid: {
                                        color: 'rgba(255,255,255,0.1)'
                                    }
                                }
                            }
                        }
                    });
                },

                createGapChart() {
                    const canvas = this.$refs.gapChart;
                    if (!canvas) return;

                    const ctx = canvas.getContext('2d');
                    const stats = this.chartData.lastAppearanceRecords || [];

                    const labels = this.selectedNumbers.length > 0 ?
                        this.selectedNumbers :
                        stats.map(item => item.loto_number);

                    const daysData = [];
                    const lastDrawDate = [];

                    labels.forEach(number => {
                        const stat = stats.find(item => item.loto_number == number);
                        if (stat) {
                            daysData.push(stat.days_not_appeared);
                            lastDrawDate.push(stat.last_draw_date);
                        } else {
                            daysData.push(0);
                            lastDrawDate.push('');
                        }
                    });

                    if (this.charts.gap) {
                        this.charts.gap.destroy();
                    }

                    this.charts.gap = new Chart(ctx, {
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
                                legend: {
                                    labels: {
                                        color: 'white'
                                    }
                                },
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
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        color: 'white'
                                    },
                                    grid: {
                                        color: 'rgba(255,255,255,0.1)'
                                    }
                                },
                                x: {
                                    ticks: {
                                        color: 'white'
                                    },
                                    grid: {
                                        color: 'rgba(255,255,255,0.1)'
                                    }
                                }
                            }
                        }
                    });
                },

                updateCharts(specialPrizeStats, allNumberStats, lastAppearanceRecords) {
                    this.chartData.specialPrizeStats = specialPrizeStats || [];
                    this.chartData.allNumberStats = allNumberStats || [];
                    this.chartData.lastAppearanceRecords = lastAppearanceRecords || [];

                    this.$nextTick(() => {
                        this.initializeCharts();
                    });
                },

                setupSocketConnection() {
                    if (window.Echo) {
                        window.Echo.channel('lottery-result')
                            .listen('.lottery.sent', (e) => {
                                e.forEach((item) => {
                                    // Handle real-time lottery data
                                    this.handleSocketData(Object.values(item.prizes || {}));
                                });
                            });
                    }
                },

                handleSocketData(data) {
                    this.lotteryDrawing.onSocketData(data);
                },

                async initLotteryDrawing(type, date, stations = []) {
                    this.lotteryDrawing = window.createLotterySystem(type);
                    await this.lotteryDrawing.init(date, stations)
                }
            },

            delimiters: ['@{{ ', ' }}']
        };

        try {
            const app = window.createVueApp(lotteryApp);
            app.mount('#vue-component');
        } catch (error) {
            console.error('Error creating/mounting Vue app:', error);
        }
    </script>
@endsection
