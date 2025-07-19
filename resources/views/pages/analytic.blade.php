@extends('layout')
@section('title', 'Phân Tích Xổ Số - Dự Đoán Số Đẹp')
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
                        <h1 class="text-2xl font-bold text-gray-800">Phân Tích Xổ Số</h1>
                        <p class="text-gray-600 text-sm">Dự đoán và phân tích số đẹp hôm nay</p>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-4">
                    <div class="text-right">
                        <p class="text-sm text-gray-600">Hôm nay</p>
                        <p class="font-semibold text-gray-800" id="current-date"></p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Introduction Section -->
        <div id="intro-section" class="fade-in">
            <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
                <div class="text-center mb-8">
                    <div
                        class="w-20 h-20 bg-primary-gradient rounded-full flex items-center justify-center mx-auto mb-4 pulse-animation">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Chào mừng đến với Hệ thống Phân tích xổ số</h2>
                    <p class="text-gray-600 text-lg max-w-3xl mx-auto">
                        Hệ thống phân tích thông minh giúp bạn nghiên cứu và dự đoán các con số may mắn.
                        Sử dụng công nghệ AI và dữ liệu lịch sử để đưa ra những phân tích chính xác nhất.
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-6 mb-8">
                    <div class="text-center p-6 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl">
                        <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Phân tích thống kê</h3>
                        <p class="text-gray-600">Dựa trên dữ liệu lịch sử để đưa ra thống kê chính xác</p>
                    </div>

                    <div class="text-center p-6 bg-gradient-to-r from-purple-50 to-purple-100 rounded-xl">
                        <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Dự đoán thông minh</h3>
                        <p class="text-gray-600">Sử dụng thuật toán AI để dự đoán xu hướng</p>
                    </div>

                    <div class="text-center p-6 bg-gradient-to-r from-green-50 to-green-100 rounded-xl">
                        <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Cập nhật realtime</h3>
                        <p class="text-gray-600">Thông tin được cập nhật liên tục theo thời gian thực</p>
                    </div>
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
                        Chọn một con số từ 00 đến 99 bên dưới để bắt đầu phân tích. Hệ thống sẽ cung cấp cho bạn
                        thông tin chi tiết về lịch sử xuất hiện, tần suất, và dự đoán khuynh hướng của con số đó.
                    </p>
                </div>
            </div>
        </div>

        <div id="analysis-section" class="hidden">
            <div class="bg-white rounded-2xl shadow-xl p-8 mb-8">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between mb-6 space-y-4 lg:space-y-0">
                    <div class="flex flex-col sm:flex-row sm:items-center space-y-3 sm:space-y-0 sm:space-x-4">
                        <button id="back-btn"
                            class="flex items-center justify-center space-x-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors w-full sm:w-auto">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            <span>Quay lại</span>
                        </button>
                        <div class="text-center sm:text-left">
                            <h2 class="text-xl sm:text-2xl font-bold text-gray-800">Kết quả phân tích</h2>
                            <p class="text-gray-600 text-sm sm:text-base">
                                <span id="analysis-type">Số đã chọn:</span>
                                <span id="selected-number" class="font-semibold text-blue-600">888</span>
                            </p>
                        </div>
                    </div>
                    <div class="text-center sm:text-right">
                        <p class="text-sm text-gray-600">Thời gian phân tích</p>
                        <p class="font-semibold text-gray-800" id="analysis-time">18/07/2025 - 14:30</p>
                    </div>
                </div>

                <!-- Loading State -->
                <div id="loading-state" class="text-center py-12">
                    <div class="loading-spinner mx-auto mb-4"></div>
                    <p class="text-gray-600">Đang phân tích dữ liệu...</p>
                </div>

                <!-- Analysis Content -->
                <div id="analysis-content" class="hidden">
                    <!-- Content will be replaced by API response -->
                </div>
            </div>
        </div>

        <!-- Number Selection Grid -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <div class="text-center mb-8">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Chọn số để phân tích</h3>
                <p class="text-gray-600">Nhấn vào một con số để phân tích đơn lẻ, hoặc chọn nhiều số để phân tích tổng hợp
                </p>
            </div>

            <!-- Selection Mode Toggle -->
            <div class="flex justify-center mb-6">
                <div class="flex items-center space-x-4 bg-gray-100 rounded-lg p-1">
                    <button id="single-mode-btn"
                        class="px-4 py-2 rounded-md text-sm font-medium transition-colors bg-blue-500 text-white">
                        Chọn đơn lẻ
                    </button>
                    <button id="multi-mode-btn"
                        class="px-4 py-2 rounded-md text-sm font-medium transition-colors text-gray-600 hover:text-gray-800">
                        Chọn nhiều số
                    </button>
                </div>
            </div>

            <!-- Multi-select controls -->
            <div id="multi-controls" class="hidden mb-6">
                <div class="flex flex-wrap justify-center items-center gap-4">
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600">Đã chọn:</span>
                        <span id="selected-count"
                            class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">0</span>
                    </div>
                    <div class="flex space-x-2">
                        <button id="select-all-btn"
                            class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white rounded-lg text-sm transition-colors">
                            Chọn tất cả
                        </button>
                        <button id="clear-all-btn"
                            class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm transition-colors">
                            Bỏ chọn tất cả
                        </button>
                        <button id="analyze-multi-btn"
                            class="px-6 py-2 bg-purple-500 hover:bg-purple-600 text-white rounded-lg text-sm font-medium transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                            disabled>
                            Phân tích tổng hợp
                        </button>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-5 sm:grid-cols-10 gap-3 max-w-4xl mx-auto">
                <!-- Numbers 00-99 will be generated by JavaScript -->
            </div>
        </div>
    </main>

    <script>
        document.getElementById('current-date').textContent = new Date().toLocaleDateString('vi-VN');

        let selectionMode = 'single';
        let selectedNumbers = new Set();

        const numberGrid = document.querySelector('.grid.grid-cols-5');
        for (let i = 0; i <= 99; i++) {
            const number = i.toString().padStart(2, '0');
            const button = document.createElement('button');
            button.className =
                'number-btn bg-primary-gradient hover:from-blue-600 hover:to-purple-700 text-white font-bold py-1 px-1 rounded-lg shadow-md';
            button.textContent = number;
            button.dataset.number = number;
            button.addEventListener('click', () => handleNumberClick(number, button));
            numberGrid.appendChild(button);
        }

        document.getElementById('single-mode-btn').addEventListener('click', () => {
            switchMode('single');
        });

        document.getElementById('multi-mode-btn').addEventListener('click', () => {
            switchMode('multi');
        });

        document.getElementById('select-all-btn').addEventListener('click', selectAll);
        document.getElementById('clear-all-btn').addEventListener('click', clearAll);
        document.getElementById('analyze-multi-btn').addEventListener('click', analyzeMultipleNumbers);

        document.getElementById('back-btn').addEventListener('click', () => {
            document.getElementById('analysis-section').classList.add('hidden');
            document.getElementById('intro-section').classList.remove('hidden');
        });

        function switchMode(mode) {
            selectionMode = mode;
            clearAll();

            if (mode === 'single') {
                document.getElementById('single-mode-btn').className =
                    'px-4 py-2 rounded-md text-sm font-medium transition-colors bg-blue-500 text-white';
                document.getElementById('multi-mode-btn').className =
                    'px-4 py-2 rounded-md text-sm font-medium transition-colors text-gray-600 hover:text-gray-800';
                document.getElementById('multi-controls').classList.add('hidden');
            } else {
                document.getElementById('multi-mode-btn').className =
                    'px-4 py-2 rounded-md text-sm font-medium transition-colors bg-blue-500 text-white';
                document.getElementById('single-mode-btn').className =
                    'px-4 py-2 rounded-md text-sm font-medium transition-colors text-gray-600 hover:text-gray-800';
                document.getElementById('multi-controls').classList.remove('hidden');
            }
        }

        function handleNumberClick(number, button) {
            if (selectionMode === 'single') {
                analyzeNumber(number);
            } else {
                toggleNumberSelection(number, button);
            }
        }

        function toggleNumberSelection(number, button) {
            if (selectedNumbers.has(number)) {
                selectedNumbers.delete(number);
                button.classList.remove('selected');
            } else {
                selectedNumbers.add(number);
                button.classList.add('selected');
            }
            updateSelectedCount();
        }

        function updateSelectedCount() {
            const count = selectedNumbers.size;
            document.getElementById('selected-count').textContent = count;
            document.getElementById('analyze-multi-btn').disabled = count === 0;
        }

        function selectAll() {
            const buttons = document.querySelectorAll('.number-btn');
            buttons.forEach(button => {
                const number = button.dataset.number;
                selectedNumbers.add(number);
                button.classList.add('selected');
            });
            updateSelectedCount();
        }

        function clearAll() {
            selectedNumbers.clear();
            document.querySelectorAll('.number-btn').forEach(button => {
                button.classList.remove('selected');
            });
            updateSelectedCount();
        }

        async function analyzeMultipleNumbers() {
            if (selectedNumbers.size === 0) return;

            const numbersArray = Array.from(selectedNumbers).sort();
            await analyzeNumbers(numbersArray);
        }

        async function analyzeNumber(number) {
            await analyzeNumbers([number]);
        }

        async function analyzeNumbers(numbersArray) {
            document.getElementById('intro-section').classList.add('hidden');
            document.getElementById('analysis-section').classList.remove('hidden');

            if (numbersArray.length === 1) {
                document.getElementById('analysis-type').textContent = 'Số đã chọn:';
                document.getElementById('selected-number').textContent = numbersArray[0];
            } else {
                document.getElementById('analysis-type').textContent = 'Các số đã chọn:';
                document.getElementById('selected-number').textContent = numbersArray.join(', ');
            }
            document.getElementById('analysis-time').textContent = new Date().toLocaleTimeString('vi-VN');

            document.getElementById('loading-state').classList.remove('hidden');
            document.getElementById('analysis-content').classList.add('hidden');

            try {
                const response = await fetch(`{{ route('ai-analytic') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        numbers: numbersArray
                    })
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const data = await response.json();

                document.getElementById('loading-state').classList.add('hidden');
                document.getElementById('analysis-content').classList.remove('hidden');
                document.getElementById('analysis-content').innerHTML = marked.parse(data.message);

            } catch (error) {
                console.error('Error fetching analysis:', error);
                showError(numbersArray.join(', '));
            }
        }

        function showError(numberText) {
            document.getElementById('loading-state').classList.add('hidden');
            document.getElementById('analysis-content').classList.remove('hidden');
            document.getElementById('analysis-content').innerHTML = `
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Không thể tải dữ liệu</h3>
                    <p class="text-gray-600">Vui lòng thử lại sau hoặc liên hệ hỗ trợ kỹ thuật.</p>
                    <button onclick="location.reload()" class="mt-4 px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors">
                        Thử lại
                    </button>
                </div>
            `;
        }

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
@endsection
