@extends('layout')
@section('title', 'Quay Thử Xố Số Mô Phỏng AI')

@section('content')
    <header class="bg-white shadow-lg">
        <div class="container mx-auto px-4 py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-primary-gradient rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Quay thử Xổ số, Mô phỏng AI</h1>
                        <p class="text-gray-600 text-sm">
                            Kết quả quay thử xổ số hôm nay sẽ lấy ngẫu nhiên từ một số kết quả dự đoán xổ số hôm nay.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="container mx-auto px-4 py-8">
        <section class="live-ticker slide-in bg-white shadow rounded-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 pb-3">
                <div class="ticker-header flex items-center gap-2">
                    <div class="live-indicator w-3 h-3 bg-red-500 rounded-full animate-pulse"></div>
                    <h2 class="text-lg font-semibold"><i class="fas fa-broadcast-tower"></i> Quay thử kết quả xổ số hôm nay
                    </h2>
                </div>
                <div class="flex justify-center md:justify-end gap-4">
                    <select id="filter-region" class="filter-input border rounded px-2 py-1 text-black">
                        <option value="XSMB">Miền Bắc</option>
                        <option value="XSMT">Miền Trung</option>
                        <option value="XSMN">Miền Nam</option>
                    </select>
                    <button class="btn btn-primary" id="simulate-draw">Quay thử</button>
                </div>
            </div>

            <div id="ticker-content" class="ticker-content grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Lottery Results and Statistics will be dynamically inserted here -->
            </div>

            <div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-xl p-6 border-l-4 border-yellow-400">
                <div class="flex items-center mb-3">
                    <svg class="w-6 h-6 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h4 class="text-lg font-semibold text-gray-800">Hướng dẫn sử dụng</h4>
                </div>

                <p class="text-gray-700">
                    <span class="block">
                        <strong>Bước 1: </strong> Chọn miền Xổ số bạn muốn quay thử.
                    </span>
                    <span class="block">
                        <strong>Bước 2: </strong> Nhấn nút quay thử và xem kết quả.
                    </span>
                    <span class="block">
                        <strong>Quay thử xổ số:</strong> Đây là công cụ mô phỏng kết quả xổ số miền dựa trên hệ
                        thống phân tích và chọn lọc ngẫu nhiên từ kho dữ liệu kết quả quay số thực tế trong hơn 10 năm qua. Kết
                        quả quay thử có thể được xem là một gợi ý mang tính tham khảo, hỗ trợ người dùng giải trí và theo dõi xu
                        hướng may mắn.
                    </span>
                    <span class="block">
                        <strong>Lưu ý:</strong> Kết quả quay thử không phải là kết quả chính thức và hoàn toàn không có giá trị
                        pháp lý. Người dùng cần cân nhắc và sử dụng thông tin một cách có trách nhiệm.
                    </span>
                </p>
            </div>
        </section>
    </div>

    <script>
        const app = {
            data: {
                filters: {
                    date: '',
                    region: 'XSMB'
                },
                lotteryXSMB: {},
                lotoNumbersXSMB: [],
                lotteryXSTN: [],
                provinceXSTN: [],
                currentDate: new Date(),
                region: 'XSMB',
                lotteryDrawing: null,
                simulateData: [],
                simulateIntervalId: null
            },

            prizeStructure: {
                XSMB: [{
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
                ],
                XSTN: [{
                        code: 'G',
                        key: 'province',
                        className: 'date-codes',
                        count: 1
                    },
                    {
                        code: '8',
                        key: 'eighth_prize',
                        className: 'last-two',
                        count: 1
                    },
                    {
                        code: '7',
                        key: 'seventh_prize',
                        className: '',
                        count: 1
                    },
                    {
                        code: '6',
                        key: 'sixth_prize',
                        className: '',
                        count: 3
                    },
                    {
                        code: '5',
                        key: 'fifth_prize',
                        className: '',
                        count: 1
                    },
                    {
                        code: '4',
                        key: 'fourth_prize',
                        className: '',
                        count: 7
                    },
                    {
                        code: '3',
                        key: 'third_prize',
                        className: '',
                        count: 2
                    },
                    {
                        code: '2',
                        key: 'second_prize',
                        className: '',
                        count: 1
                    },
                    {
                        code: '1',
                        key: 'first_prize',
                        className: '',
                        count: 1
                    },
                    {
                        code: 'ĐB',
                        key: 'special_prize',
                        className: 'special-prize',
                        count: 1
                    }
                ]
            },
            init() {
                this.initializeData();
                this.setupEventListeners();
            },

            setupEventListeners() {
                document.getElementById('filter-region').addEventListener('change', () => this.filterRegion());
                document.getElementById('simulate-draw').addEventListener('click', () => this.simulateDraw());
            },

            async initializeData() {
                this.fetchSimulateDraw();
            },

            async fetchSimulateDraw() {
                try {
                    const params = new URLSearchParams({
                        region: this.data.filters.region
                    });
                    const response = await fetch(`{{ route('simulate-draw') }}?${params}`, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    });
                    if (!response.ok) throw new Error('Failed to fetch lottery data');
                    const data = await response.json();

                    this.data.simulateData = data.dataSimulate;
                    this.data.currentDate = data.date;

                    if (this.data.filters.region !== 'XSMB') {
                        this.data.lotteryXSTN = data.dataSimulate;
                        this.data.provinceXSTN = Object.values(this.data.lotteryXSTN).map((it) => it.lottery
                            ?.province || null);
                    }

                    this.renderTickerContent();

                } catch (error) {
                    console.error(error);
                }
            },

            renderTickerContent() {
                const content = document.getElementById('ticker-content');
                content.innerHTML = '';
                const lotteryTitle = {
                    XSMB: 'XSMB - Kết quả xổ số miền Bắc',
                    XSMN: 'XSMN - Kết quả xổ số miền Nam',
                    XSMT: 'XSMT - Kết quả xổ số miền Trung'
                } [this.data.region] || 'Kết quả xổ số';

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
                                <div class="region-title text-lg font-semibold"><h3>Tổng hợp loto - ${this.formatDate(this.data.currentDate)}</h3></div>
                                ${Array.from({ length: 10 }, (_, i) => ` <
                        div class = "result-numbers flex gap-2 my-2" >
                        <
                        div > Đầu $ {
                            i
                        }: < /div>
                    $ {
                        this.getLotoByHead(this.data.lotoNumbersXSMB, i).map(({
                            item,
                            index
                        }) => `
                                            <div class="number-ball text-white p-2 bg-gray-100 rounded ${index === 26 ? 'bg-red text-white' : ''}">
                                                ${item}
                                            </div>
                                        `).join('')
                    } <
                    /div>
                    `).join('')}
                            </div>
                        </div>
                    `;
                } else {
                    html +=
                        `
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
                                        <div class="region-title text-lg font-semibold"><h3>Tổng hợp loto - ${it.lottery?.province ?? 'Chưa xác định'} - ${this.formatDate(this.data.currentDate)}</h3></div>
                                        ${Array.from({ length: 10 }, (_, i) => `
                                        <div class="result-numbers flex gap-2 my-2">
                                            <div>Đầu ${i}: </div>
                                            ${this.getLotoByHead(it.loto ,i)? this.getLotoByHead(it.loto ,i).map(({ item, index }) => ` <
                        div class =
                        "number-ball text-white p-2 bg-gray-100 rounded ${index === 17 ? 'bg-red text-white' : ''}" >
                        $ {
                            item ?? ''
                        } <
                        /div>
                    `).join('') : ''}
                                        </div>
                                    `).join('')
            } <
            /div> <
            /div>
            `)}
                    `;
        }

        content.innerHTML = html;
        },

        getPrizeNumbers(prize) {
                const data = this.data.lotteryXSMB[prize.key] || [];
                const result = [];
                for (let i = 0; i < prize.count; i++) {
                    result.push(data[i] || null);
                }

                return result;
            },

            async filterRegion() {
                    this.data.filters.region = document.getElementById('filter-region').value;

                    if (this.data.simulateIntervalId) {
                        clearInterval(this.data.simulateIntervalId);
                        this.data.simulateIntervalId = null;
                    }

                    await this.fetchSimulateDraw();
                },

                async simulateDraw() {
                        this.renderTickerContent();

                        this.data.lotteryDrawing = window.createLotterySystem(this.data.filters.region);

                        if (this.data.filters.region === 'XSMB') {
                            this.data.lotteryDrawing.startDrawing();
                            let data = [];
                            let index = 0;
                            this.data.simulateIntervalId = setInterval(() => {

                                if (index >= this.data.simulateData.length) {
                                    clearInterval(this.data.simulateIntervalId);
                                    return;
                                }

                                data.push(this.data.simulateData[index]);
                                this.data.lotteryDrawing.onSocketData([...data]);

                                index++;
                            }, 1000);

                        } else {
                            this.data.lotteryDrawing.startAllStationDrawings(this.data.provinceXSTN);
                            let index = 0;
                            const data = {};

                            this.data.simulateIntervalId = setInterval(() => {
                                let hasMore = false;

                                this.data.simulateData.forEach(item => {
                                    const province = item.lottery.province;
                                    const numbers = item.lottery.allNumbers;

                                    if (index < numbers.length) {
                                        if (!data[province]) {
                                            data[province] = [];
                                        }

                                        data[province].push(numbers[index]);
                                        hasMore = true;
                                    }
                                });

                                if (!hasMore) {
                                    clearInterval(this.data.simulateIntervalId);
                                    return;
                                }

                                this.data.lotteryDrawing.onSocketData({
                                    ...data
                                });

                                index++;
                            }, 1000);
                        }

                    },

                    getPrizeNumbersXSTN(prize, lottery) {
                        const safeLottery = lottery ?? {};
                        const data = safeLottery[prize.key] || [];
                        const result = [];

                        for (let i = 0; i < prize.count; i++) {
                            result.push(
                                prize.key === 'province' ?
                                (data ?? null) :
                                (Array.isArray(data) ? (data[i] ?? null) : null)
                            );
                        }
                        return result;
                    },

                    getLotoByHead(lottery, head) {
                        return lottery?.map((item, index) => ({
                                item,
                                index
                            }))
                            .filter(({
                                item
                            }) => item.charAt(0) == head);
                    },

                    formatDate(date) {
                        return new Date(date).toLocaleDateString('vi-VN');
                    },

                    playNumbers(index = 0) {
                        if (index >= numbers.length) return;

                        data.push(numbers[index]);
                        this.data.lotteryDrawing.onSocketData([...data]);

                        setTimeout(() => {
                            playNumbers(index + 1);
                        }, 1000);
                    }
        }

        document.addEventListener('DOMContentLoaded', () => app.init());
    </script>
@endsection
