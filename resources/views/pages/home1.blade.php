@extends('layout')

@section('content')
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
                    <span class="loading"></span>
                </div>
                <div class="flex justify-end gap-4">
                    <input type="date" name="date" id="" class="filter-input">
                    <select name="region" id="" class="filter-input text-black">
                        <option value="XSMB">Miền bắc</option>
                        <option value="XSMT">Miền Trung</option>
                        <option value="XSMN">Miền Nam</option>
                    </select>
                </div>
            </div>
            <div class="ticker-content grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="container" id="lottery-result">
                    <div class="breadcrumb">
                        <a href="#">Kết quả xổ số</a>
                    </div>

                    <table class="results-table">
                        <tr>
                            <td class="prize-code">Mã ĐB</td>
                            <td class="prize-numbers grid grid-cols-6">
                                <span class="date-codes">
                                    <div class="loading-number"></div>
                                </span>
                                <span class="date-codes">
                                    <div class="loading-number"></div>
                                </span>
                                <span class="date-codes">
                                    <div class="loading-number"></div>
                                </span>
                                <span class="date-codes">
                                    <div class="loading-number"></div>
                                </span>
                                <span class="date-codes">
                                    <div class="loading-number"></div>
                                </span>
                                <span class="date-codes">
                                    <div class="loading-number"></div>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td class="prize-code">G.ĐB</td>
                            <td class="prize-numbers grid grid-cols-1">
                                <div class="number special-prize" id="special-prize">
                                    <div class="loading-number"></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="prize-code">G.1</td>
                            <td class="prize-numbers grid grid-cols-1">
                                <div class="number first-prize" id="first-prize">
                                    <div class="loading-number"></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="prize-code">G.2</td>
                            <td class="prize-numbers grid grid-cols-2" id="second-prizes">
                                <div class="number">
                                    <div class="loading-number"></div>
                                </div>
                                <div class="number">
                                    <div class="loading-number"></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="prize-code">G.3</td>
                            <td class="prize-numbers grid grid-cols-3" id="third-prizes">
                                <div class="number">
                                    <div class="loading-number"></div>
                                </div>
                                <div class="number">
                                    <div class="loading-number"></div>
                                </div>
                                <div class="number">
                                    <div class="loading-number"></div>
                                </div>
                                <div class="number">
                                    <div class="loading-number"></div>
                                </div>
                                <div class="number">
                                    <div class="loading-number"></div>
                                </div>
                                <div class="number">
                                    <div class="loading-number"></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="prize-code">G.4</td>
                            <td class="prize-numbers grid grid-cols-2 md:grid-cols-4" id="fourth-prizes">

                                <div class="number">
                                    <div class="loading-number"></div>
                                </div>
                                <div class="number">
                                    <div class="loading-number"></div>
                                </div>
                                <div class="number">
                                    <div class="loading-number"></div>
                                </div>
                                <div class="number">
                                    <div class="loading-number"></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="prize-code">G.5</td>
                            <td class="prize-numbers grid grid-cols-3" id="fifth-prizes">
                                <div class="number">
                                    <div class="loading-number"></div>
                                </div>
                                <div class="number">
                                    <div class="loading-number"></div>
                                </div>
                                <div class="number">
                                    <div class="loading-number"></div>
                                </div>
                                <div class="number">
                                    <div class="loading-number"></div>
                                </div>
                                <div class="number">
                                    <div class="loading-number"></div>
                                </div>
                                <div class="number">
                                    <div class="loading-number"></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="prize-code">G.6</td>
                            <td class="prize-numbers grid grid-cols-3" id="sixth-prizes">
                                <div class="number">
                                    <div class="loading-number"></div>
                                </div>
                                <div class="number">
                                    <div class="loading-number"></div>
                                </div>
                                <div class="number">
                                    <div class="loading-number"></div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="prize-code">G.7</td>
                            <td class="prize-numbers grid grid-cols-4" id="seventh-prizes">
                                <div class="number last-two">
                                    <div class="loading-number"></div>
                                </div>
                                <div class="number last-two">
                                    <div class="loading-number"></div>
                                </div>
                                <div class="number last-two">
                                    <div class="loading-number"></div>
                                </div>
                                <div class="number last-two">
                                    <div class="loading-number"></div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div>
                    <div id="lottery-result-statis"></div>

                    <!-- AI Predictions -->
                    <div class="predictions">
                        <h3 class="mb-3"><i class="fas fa-robot"></i> Dự đoán AI cho lần quay tiếp theo</h3>
                        <div class="prediction-cards">
                            <div class="prediction-card">
                                <div class="prediction-title">Bạch thủ lô XSMB</div>
                                <div class="prediction-numbers">
                                    <div class="number-ball">47</div>
                                </div>
                                <div class="confidence-bar">
                                    <div class="confidence-fill" style="width: 87%"></div>
                                </div>
                                <small>Độ tin cậy: 87%</small>
                            </div>
                            <div class="prediction-card">
                                <div class="prediction-title">Song thủ lô</div>
                                <div class="prediction-numbers">
                                    <div class="number-ball">23</div>
                                    <div class="number-ball">78</div>
                                </div>
                                <div class="confidence-bar">
                                    <div class="confidence-fill" style="width: 74%"></div>
                                </div>
                                <small>Độ tin cậy: 74%</small>
                            </div>
                            <div class="prediction-card">
                                <div class="prediction-title">3 càng</div>
                                <div class="prediction-numbers">
                                    <div class="number-ball">5</div>
                                    <div class="number-ball">6</div>
                                    <div class="number-ball">7</div>
                                </div>
                                <div class="confidence-bar">
                                    <div class="confidence-fill" style="width: 65%"></div>
                                </div>
                                <small>Độ tin cậy: 65%</small>
                            </div>
                            <div class="prediction-card">
                                <div class="prediction-title">Dàn đề 10 số</div>
                                <div class="prediction-numbers">
                                    <div class="number-ball" style="font-size: 0.7rem;">12</div>
                                    <div class="number-ball" style="font-size: 0.7rem;">90</div>
                                    <div class="number-ball" style="font-size: 0.7rem;">34</div>
                                    <div class="number-ball" style="font-size: 0.7rem;">56</div>
                                    <div class="number-ball" style="font-size: 0.7rem;">78</div>
                                </div>
                                <div class="confidence-bar">
                                    <div class="confidence-fill" style="width: 82%"></div>
                                </div>
                                <small>Độ tin cậy: 82%</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->

            <div class="mt-3">
                <h3 class="mb-3"><i class="fas fa-robot"></i> Lịch sử dự đoán giải đặc biệt (10 số/ngày) của AI và kết quả đối chiếu thực tế cách đây 10 ngày</h3>
                <div class="quick-stats">
                    <div class="stat-card">
                        <div class="stat-number" id="accuracy-percent">100%</div>
                        <div class="stat-label">Độ chính xác của AI</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number"><span class="text-3xl" id="latest-hit">y-d-m</span></div>
                        <div class="stat-label">Ngày đoán đúng gần nhất</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number" id="max-streak">10</div>
                        <div class="stat-label">Chuỗi ngày đoán đúng liên tiếp</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number"><button class="cursor-pointer" id="openHistoryModal"><i class="fas fa-eye"></i></button></div>
                        <div class="stat-label">Lịch sử dự đoán</div>
                    </div>
                </div>
            </div>
        </section>

        <section id="dashboard" class="dashboard">
            <h2 class="section-title">Thống kê kết quả</h2>

            <!-- Analysis Tools -->
            <div class="analysis-tools">
                {{-- <h3 class="text-center mb-6"><i class="fas fa-tools"></i> Công cụ phân tích nâng cao</h3> --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div class="dashboard-card mx-auto">
                        <div class="card-header">
                            <h3 class="card-title">Chọn số để thống kê</h3>
                        </div>
                        <div class="heatmap-container">
                            <div class="heatmap-grid" id="heatmapGrid"></div>
                        </div>
                    </div>

                    <form id="form-statis-loto" method="get">
                        <div class="tool-filters">
                            <div class="filter-group">
                                <label class="filter-label">Biên độ</label>
                                <select class="filter-input" name="days_period">
                                    <option value="7">7 ngày qua</option>
                                    <option value="30">30 ngày qua</option>
                                    <option value="45">45 ngày qua</option>
                                    <option value="60">60 ngày qua</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label class="filter-label">Miền</label>
                                <select class="filter-input" name="region">
                                    <option value="XSMB">Miền Bắc</option>
                                    <option value="XSMT">Miền Trung</option>
                                    <option value="XSMN">Miền Nam</option>
                                </select>
                            </div>

                            <div class="filter-group">
                                <label class="filter-label">Ngày thống kê</label>
                                <input type="date" class="filter-input" name="date">
                            </div>
                        </div>
                        <button class="btn btn-primary">Áp dụng bộ lọc</button>
                    </form>

                </div>
            </div>

            <!-- Dashboard Grid -->
            <div class="dashboard-grid">
                <!-- Frequency Analysis Chart -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3 class="card-title">Thống kê số lần ra của giải đặc biệt</h3>
                        <i class="fas fa-chart-bar card-icon"></i>
                    </div>
                    <div class="chart-container">
                        <canvas id="frequencyChart"></canvas>
                    </div>
                </div>

                <!-- Trend Analysis -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3 class="card-title">Thống kê số lần ra của tất cả giải</h3>
                        <i class="fas fa-chart-bar card-icon"></i>
                    </div>
                    <div class="chart-container">
                        <canvas id="trendChart"></canvas>
                    </div>
                </div>

                <!-- Hot/Cold Numbers Heatmap -->

                <!-- Gap Analysis -->
                <div class="dashboard-card">
                    <div class="card-header">
                        <h3 class="card-title">Thống kê số ngày chưa ra</h3>
                        <i class="fas fa-chart-line card-icon"></i>
                    </div>
                    <div class="chart-container">
                        <canvas id="gapChart"></canvas>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div id="historyModal" class="relative z-10 hidden" aria-labelledby="history-title" role="dialog"
        aria-modal="true">
        <div class="fixed inset-0 bg-gray-500/75 transition-opacity ease-out duration-300 opacity-0" aria-hidden="true"
            id="historyBackdrop"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4">
                <div id="historyPanel"
                    class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all ease-out duration-300 opacity-0 translate-y-4 sm:scale-95 w-full max-w-6xl">
                    <!-- Header -->
                    <div class="header-background-modal px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div
                                    class="flex-shrink-0 w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 033" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-white" id="history-title">Lịch Sử Dự Đoán AI
                                    </h3>
                                    <p class="text-blue-100 text-sm">Kết quả dự đoán 10 ngày gần nhất</p>
                                </div>
                            </div>
                            <button class="btn-close" class="text-white/80 hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="max-h-[70vh] overflow-y-auto">
                        <div id="historyContent" class="p-6">
                            <!-- Content will be populated by JavaScript -->
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="bg-gray-50 px-6 py-4 border-t">
                        <div class="flex justify-between items-center">
                            <button
                                class="btn-close inline-flex items-center px-3 py-2 text-sm rounded-md bg-primary-gradient color-muted">
                                Đóng
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            lotteryDrawing.init();
            echoChannel = window.Echo.channel('lottery-result')
                .listen('.lottery.sent', (e) => {
                    e.forEach((item) => {
                        lotteryDrawing.onSocketData(Object.values(item.prizes || {}));
                    })
                });
        });

        // Các hàm để gọi từ HTML
        function testDrawing(region) {
            lotteryDrawing.startDrawing(region);
        }

        function stopDrawing() {
            lotteryDrawing.test();
        }

        // Hàm showToast cho tương thích với code cũ
        function showToast(message, type) {
            if (lotteryDrawing) {
                lotteryDrawing.showToast(message, type);
            }
        }
        // Initialize the website
        document.addEventListener('DOMContentLoaded', function() {
            initialzeLotteryResult('', '');
            initializeBaseStatisLotoData();
            initialzeAiPredictionSpecialPrize();
            initializeHeatmap();
            initializeChatbot();
            initializeMobileMenu();
            initializeSubmitStatisLoto();
        });

        let numbersSelect = [];
        let dateCurrent = new Date();

        async function initialzeLotteryResult(date, region) {
            const lotteryResultStatis = document.getElementById('lottery-result-statis');
            const lotteryResult = document.getElementById('lottery-result');

            const data = await fetchlotteryData(date, region);

            if (!data) {
                showToast('Không tìm thấy dữ liệu xổ số', 'error');
                return;
            }

            const lottery = data.lottery || [];
            const loto = Object.values(data.loto || {});
            dateCurrent = data.date;

            const regionTitles = {
                XSMB: 'XSMB - Kết quả xổ số miền Bắc',
                XSMN: 'XSMN - Kết quả xổ số miền Nam',
                XSMT: 'XSMT - Kết quả xổ số miền Trung',
            };

            const type = regionTitles[lottery?.region] || 'Kết quả xổ số';

            const tableHTML = `
                        ${renderPrizeRow('Mã ĐB', lottery?.special_code || [], lottery?.special_code?.length, lottery?.special_code?.length, 'date-codes')}
                        ${renderPrizeRow('G.ĐB', lottery?.special_prize || [], 1, 1, 'special-prize')}
                        ${renderPrizeRow('G.1', lottery?.first_prize || [])}
                        ${renderPrizeRow('G.2', lottery?.second_prize || [], 2, 2)}
                        ${renderPrizeRow('G.3', lottery?.third_prize || [], 3, 6)}
                        ${renderPrizeRow('G.4', lottery?.fourth_prize || [], 2, 4, '4')}
                        ${renderPrizeRow('G.5', lottery?.fifth_prize || [], 3, 6)}
                        ${renderPrizeRow('G.6', lottery?.sixth_prize || [], 3, 3)}
                        ${renderPrizeRow('G.7', lottery?.seventh_prize || [], 4, 4, 'last-two')}
                        `;

            lotteryResult.innerHTML = `<div class="breadcrumb">
                                        <a href="#">${type} - ${formatDate(lottery?.draw_date || dateCurrent)}</a>
                                    </div>
                                    <table class="results-table">
                                        ${tableHTML}
                                    </table>
                                    `;

            const numberBlocks = Array.from({
                length: 10
            }, (_, i) => {
                const numbers = loto
                    .map((item, index) => ({
                        item,
                        index
                    }))
                    .filter(({
                        item
                    }) => item.charAt(0) == i)
                    .map(({
                            item,
                            index
                        }) =>
                        `<div class="number-ball ${index === 26 ? 'bg-red': ''}">${item}</div>`
                    )
                    .join('');
                return `<div class="result-numbers"><div>Đầu ${i}: </div>${numbers}</div>`;
            }).join('');

            lotteryResultStatis.innerHTML = `
                    <div class="region-result">
                        <div class="region-title">Tổng hợp loto - ${formatDate(lottery?.draw_date || dateCurrent)}</div>
                        ${numberBlocks}
                    </div>
                `;
        }

        function renderPrizeRow(prizeCode, prizeData = [], columns = 1, requiredCount = 1, className = '', colsMd = '') {
            const colClass = `grid-cols-${columns} md:grid-cols-${colsMd}`;

            const prizeHtml = Array.from({
                length: requiredCount
            }, (_, index) => {
                const num = prizeData[index];
                return num ? `<div class="number ${className}">${num}</div>` :
                    `<div class="number ${className}"><div class="loading-number"></div></div>`;
            }).join('');

            return `<tr>
                        <td class="prize-code">${prizeCode}</td>
                        <td class="prize-numbers grid ${colClass}">
                            ${prizeHtml}
                        </td>
                    </tr>
                `;
        }

        function formatDate(dateStr) {
            const date = new Date(dateStr);
            return date.toLocaleDateString('vi-VN');
        }

        let predictionData = [];
        async function initialzeAiPredictionSpecialPrize() {
            const data = await fetchAiPredictionSpecialPrizeData();

            if (!data) {
                showToast('Không tìm thấy dữ liệu dự đoán AI', 'error');
                return;
            }

            predictionData = Object.values(data.stats);

            document.getElementById("accuracy-percent").innerText = data.accuracy_percent + "%";
            document.getElementById("latest-hit").innerText = data.latest_hit.date;
            document.getElementById("max-streak").innerText = data.max_streak;
        }

        async function fetchlotteryData(date, region) {
            try {
                const response = await fetch(
                    `{{ config('api_endpoint.get_lottery_result') }}?date=${date}&region=${region}`, {
                        method: "GET",
                        headers: {
                            'Accept': 'application/json'
                        }
                    });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Lỗi khi lấy dữ liệu');
                }

                return data;
            } catch (error) {
                console.Error(error);

                showToast(`Có lỗi xảy ra khi lấy dữ liệu xổ số: ${error.message}`, 'error');
                return null;
            }
        }

        async function fetchAiPredictionSpecialPrizeData(date, region) {
            try {
                const response = await fetch(
                    `{{ config('api_endpoint.ai_prediction_special_prize') }}?date=${date}&region=${region}`, {
                        method: "GET",
                        headers: {
                            'Accept': 'application/json'
                        }
                    });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Lỗi khi lấy dữ liệu');
                }

                return data;
            } catch (error) {
                console.Error(error);

                showToast(`Có lỗi xảy ra khi lấy dữ liệu xổ số: ${error.message}`, 'error');
                return null;
            }
        }

        async function initializeSubmitStatisLoto() {
            const form = document.getElementById('form-statis-loto');

            if (!form) {
                console.error('Form with ID "form-statis-loto" not found');
                return;
            }

            form.addEventListener('submit', async (e) => {
                e.preventDefault();

                const formData = new FormData(e.target);

                const date = formData.get('date') || '';
                const daysPeriod = formData.get('days_period') || '';
                const region = formData.get('region') || '';

                const data = await fetchBaseStatisLotoData(numbersSelect, date, daysPeriod, region);

                if (!data) {
                    showToast('Không có dữ liệu thống kê', 'error');
                    return;
                }

                initializeCharts(data.special_prize_stats, data.all_number_stats, data
                    .lastAppearanceRecords);
            });
        }

        async function initializeBaseStatisLotoData() {
            const data = await fetchBaseStatisLotoData();

            if (!data) {
                showToast('Không có dữ liệu thống kê', 'error');
                return;
            }

            initializeCharts(data.special_prize_stats, data.all_number_stats, data.lastAppearanceRecords);
        }

        async function fetchBaseStatisLotoData(numbers = [], date = '', days_period = '', region = '') {
            try {
                const query = new URLSearchParams({
                    numbers: numbers.join(','),
                    date,
                    days_period,
                    region
                });

                const response = await fetch(
                    `{{ config('api_endpoint.base_statis') }}?${query.toString()}`, {
                        method: "GET",
                        headers: {
                            'Accept': 'application/json'
                        }
                    }
                );

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Lỗi khi lấy dữ liệu');
                }

                return data;
            } catch (error) {
                showToast(`Có lỗi xảy ra khi lấy dữ liệu xổ số: ${error.message}`, 'error');
                return null;
            }
        }

        let frequencyChartInstance = null;
        let trendChartInstance = null;
        let gapChartInstance = null;

        function initializeCharts(specialPrizeStats, allNumberStats, lastAppearanceRecords) {
            const freqCtx = document.getElementById('frequencyChart');

            if (freqCtx) {
                const labels = numbersSelect.length > 0 ? numbersSelect : (specialPrizeStats?.map(item => item
                    .loto_number) || []);
                const freqData = [];
                const drawDates = [];

                labels.forEach(number => {
                    const stat = specialPrizeStats.find(item => item.loto_number === number);
                    if (stat) {
                        freqData.push(stat.frequency);
                        drawDates.push(stat.draw_dates);
                    } else {
                        freqData.push(0);
                        drawDates.push('');
                    }
                });

                const chartData = {
                    labels: labels,
                    datasets: [{
                        label: 'Tần suất xuất hiện',
                        data: freqData,
                        backgroundColor: '#99cccc82',
                        borderColor: '#9cc',
                        borderWidth: 1
                    }]
                };

                const chartOptions = {
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
                                afterBody: function(context) {
                                    const index = context[0].dataIndex;
                                    const dates = drawDates[index]?.split(',')?.join(', ');
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
                                color: 'rgba(255, 255, 255, 0.1)'
                            }
                        },
                        x: {
                            ticks: {
                                color: 'white'
                            },
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            }
                        }
                    }
                };

                if (frequencyChartInstance) {
                    frequencyChartInstance.data = chartData;
                    frequencyChartInstance.options = chartOptions;
                    frequencyChartInstance.update();
                } else {
                    frequencyChartInstance = new Chart(freqCtx, {
                        type: 'bar',
                        data: chartData,
                        options: chartOptions
                    });
                }
            }

            // ==== Trend Chart ====
            const trendCtx = document.getElementById('trendChart');

            if (trendCtx) {

                const labels = numbersSelect.length > 0 ? numbersSelect : (allNumberStats?.map(item => item.loto_number) ||
                    []);
                const freqData = [];
                const drawDates = [];

                labels.forEach(number => {
                    const stat = allNumberStats.find(item => item.loto_number === number);
                    if (stat) {
                        freqData.push(stat.frequency);
                        drawDates.push(stat.draw_dates);
                    } else {
                        freqData.push(0);
                        drawDates.push('');
                    }
                });

                const trendData = {
                    labels: labels,
                    datasets: [{
                        label: 'Số lần xuất hiện: ',
                        data: freqData,
                        backgroundColor: 'rgba(72, 187, 120, 0.6)',
                        borderColor: '#48bb78',
                        borderWidth: 1
                    }]
                };

                const trendOptions = {
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
                                afterBody: function(context) {
                                    const index = context[0].dataIndex;
                                    const dates = drawDates[index].split(',').join(
                                        '\n'); // thay dấu phẩy thành xuống dòng
                                    return 'Ngày xuất hiện:\n' + dates;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            ticks: {
                                color: 'white'
                            },
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            }
                        },
                        x: {
                            beginAtZero: true,
                            ticks: {
                                color: 'white'
                            },
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            }
                        }
                    }
                };

                if (trendChartInstance) {
                    trendChartInstance.data = trendData;
                    trendChartInstance.options = trendOptions;
                    trendChartInstance.update();
                } else {
                    trendChartInstance = new Chart(trendCtx, {
                        type: 'bar',
                        data: trendData,
                        options: trendOptions
                    });
                }
            }

            // ==== Gap Chart ====
            const gapCtx = document.getElementById('gapChart');

            if (gapCtx) {

                const labels = numbersSelect.length > 0 ? numbersSelect : (lastAppearanceRecords?.map(item => item
                    .loto_number) || []);
                const daysData = [];
                const lastDrawDate = [];


                labels.forEach(number => {
                    const stat = lastAppearanceRecords.find(item => item.loto_number === number);
                    if (stat) {
                        daysData.push(stat.days_not_appeared);
                        lastDrawDate.push(stat.last_draw_date);
                    } else {
                        daysData.push(0);
                        lastDrawDate.push('');
                    }
                });

                const gapData = {
                    labels: labels,
                    datasets: [{
                        label: 'Số ngày chưa xuất hiện',
                        data: daysData,
                        borderColor: '#f56565',
                        backgroundColor: 'rgba(245, 101, 101, 0.2)',
                        tension: 0.3,
                        fill: true
                    }]
                };

                const gapOptions = {
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
                                afterBody: function(context) {
                                    const index = context[0].dataIndex;
                                    const dates = lastDrawDate[index].split(',').join(
                                        ' '); // thay dấu phẩy thành xuống dòng
                                    return 'Ngày ra gần nhất: ' + dates;
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
                                color: 'rgba(255, 255, 255, 0.1)'
                            }
                        },
                        x: {
                            ticks: {
                                color: 'white'
                            },
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            }
                        }
                    }
                };

                if (gapChartInstance) {
                    gapChartInstance.data = gapData;
                    gapChartInstance.options = gapOptions;
                    gapChartInstance.update();
                } else {
                    gapChartInstance = new Chart(gapCtx, {
                        type: 'line',
                        data: gapData,
                        options: gapOptions
                    });
                }
            }
        }

        // Heatmap Initialization
        function initializeHeatmap() {
            const heatmapGrid = document.getElementById('heatmapGrid');
            if (heatmapGrid) {
                for (let i = 0; i < 100; i++) {
                    const cell = document.createElement('div');
                    cell.className = 'heatmap-cell';
                    cell.textContent = i.toString().padStart(2, '0');

                    cell.addEventListener('click', () => {
                        cell.style.background = `rgba(217, 188, 38, 0.886)`;

                        const intensity = Math.random();
                        showToast(`Số ${i.toString().padStart(2, '0')}: Tần suất ${Math.floor(intensity * 100)}%`,
                            'info');
                        numbersSelect.push(i.toString().padStart(2, '0'));

                    });

                    heatmapGrid.appendChild(cell);
                }
            }
        }

        // Chatbot Functionality
        function initializeChatbot() {
            const chatbotToggle = document.getElementById('chatbotToggle');
            const chatbotContainer = document.getElementById('chatbot');
            const chatbotClose = document.getElementById('chatbotClose');
            const chatbotSend = document.getElementById('chatbotSend');
            const chatbotInput = document.getElementById('chatbotInput');
            const chatbotMessages = document.getElementById('chatbotMessages');

            chatbotToggle.addEventListener('click', () => {
                chatbotContainer.style.display = chatbotContainer.style.display === 'flex' ? 'none' : 'flex';
            });

            chatbotClose.addEventListener('click', () => {
                chatbotContainer.style.display = 'none';
            });

            function sendMessage() {
                const message = chatbotInput.value.trim();
                if (message) {
                    addMessage(message, 'user');
                    chatbotInput.value = '';

                    // Simulate AI response
                    setTimeout(() => {
                        const responses = [
                            'Dựa trên phân tích dữ liệu, số 47 có khả năng cao xuất hiện trong 3 ngày tới.',
                            'Tôi đề xuất bạn nên theo dõi cầu lô của số 23, đã gan 12 ngày.',
                            'Xu hướng hiện tại cho thấy dàn đề 12-34-56 có tỷ lệ thành công 78%.',
                            'Phân tích AI cho thấy XSMB đang trong chu kỳ số chẵn, hãy cân nhắc kỹ.'
                        ];
                        const randomResponse = responses[Math.floor(Math.random() * responses.length)];
                        addMessage(randomResponse, 'bot');
                    }, 1000);
                }
            }

            function addMessage(message, sender) {
                const messageDiv = document.createElement('div');
                messageDiv.className = `${sender}-message`;
                messageDiv.innerHTML = `
                    <div class="message-avatar">
                        <i class="fas fa-${sender === 'user' ? 'user' : 'robot'}"></i>
                    </div>
                    <div class="message-content">${message}</div>
                `;
                chatbotMessages.appendChild(messageDiv);
                chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
            }

            chatbotSend.addEventListener('click', sendMessage);
            chatbotInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') sendMessage();
            });
        }

        // Mobile Menu
        function initializeMobileMenu() {
            const mobileToggle = document.getElementById('mobileMenuToggle');
            const navMenu = document.querySelector('.nav-menu');

            if (mobileToggle && navMenu) {
                mobileToggle.addEventListener('click', () => {
                    navMenu.classList.toggle('active');
                });
            }
        }


        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `toast ${type}`;
            toast.textContent = message;

            const container = document.getElementById('toastContainer');
            container.appendChild(toast);

            toast.addEventListener('click', () => {
                toast.remove();
            });

            setTimeout(() => {
                if (toast.parentNode) {
                    toast.remove();
                }
            }, 5000);
        }

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Add fade-in animation to elements when they come into view
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.dashboard-card, .stat-card, .prediction-card').forEach(el => {
            observer.observe(el);
        });

        // Service Worker for PWA functionality
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(registration => {
                        console.log('SW registered: ', registration);
                    })
                    .catch(registrationError => {
                        console.log('SW registration failed: ', registrationError);
                    });
            });
        }


        // Initialize modals
        window.addEventListener('DOMContentLoaded', async () => {
            const historyModal = await new Modal('historyModal', 'historyBackdrop', 'historyPanel');

            document.getElementById('openHistoryModal').addEventListener('click', () => {
                generateHistoryContent();
                historyModal.open();
            });

            document.querySelectorAll('.btn-close').forEach((element) => {
                element.addEventListener('click', () => historyModal.close());
            })

            historyModal.backdrop.addEventListener('click', () => {if (historyModal.isOpen) historyModal.close();})

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    [historyModal].forEach(modal => {
                        if (modal.isOpen) modal.close();
                    });
                }
            });

            // Prevent clicks inside modal from closing it
            document.querySelectorAll('[id$="Panel"]').forEach(panel => {
                panel.addEventListener('click', (e) => e.stopPropagation());
            });
        })

        // Format date
        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('vi-VN', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }

        // Generate history content
        function generateHistoryContent() {
            const content = document.getElementById('historyContent');

            let html = '<div class="space-y-6">';

            predictionData.forEach((item, index) => {
                const isHit = item.hit > 0;
                const hitClass = isHit ? 'border-green-200 bg-green-50' : 'border-gray-200 bg-white';
                const statusClass = isHit ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
                const statusText = isHit ? `Dự đoán đúng` : 'Dự đoán sai';

                html += `
                    <div class="border ${hitClass} rounded-lg p-6 transition-all hover:shadow-md">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-4">
                            <div class="flex items-center mb-2 lg:mb-0">
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                    <span class="text-blue-600 font-bold text-lg">${index + 1}</span>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900">${formatDate(item.date)}</h4>
                                    <p class="text-sm text-gray-500">Ngày quay: ${item.date}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium ${statusClass}">
                                    ${statusText}
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
                                    ${item.predicted.map(num => {
                                        const isMatch = num === item.tail;
                                        const numClass = isMatch ? 'bg-green-500 text-white ring-2 ring-green-300' : 'bg-gray-100 text-gray-700';
                                        return `<div class="w-10 h-10 rounded-lg ${numClass} flex items-center justify-center text-sm font-bold">${num}</div>`;
                                    }).join('')}
                                </div>
                                ${isHit ? `<p class="text-xs text-green-600 mt-2 font-medium">✓ Số đúng: ${item.predicted.filter(num => num === item.tail).join(', ')}</p>` : ''}
                            </div>
                        </div>
                    </div>
                `;
            });

            html += '</div>';
            content.innerHTML = html;
        }
    </script>
@endsection
