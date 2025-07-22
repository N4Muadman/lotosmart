@extends('layout')
@section('title', 'Phân Tích Xổ Số & Giấc Mơ - Dự Đoán Số Đẹp')
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
                        <h1 class="text-2xl font-bold text-gray-800">Phân Tích Xổ Số Và Giấc Mơ</h1>
                        <p class="text-gray-600 text-sm">Dự đoán số đẹp từ thống kê và giải mã giấc mơ</p>
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
                    <div class="w-20 h-20 bg-primary-gradient rounded-full flex items-center justify-center mx-auto mb-4 pulse-animation">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">Hệ thống Phân tích Xổ số & Giấc mơ</h2>
                    <p class="text-gray-600 text-lg max-w-3xl mx-auto">
                        Hệ thống thông minh giúp bạn phân tích số đẹp từ thống kê xổ số và giải mã những con số may mắn từ giấc mơ của bạn.
                        Sử dụng công nghệ AI và dữ liệu lịch sử để đưa ra những dự đoán chính xác nhất.
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
                        <p class="text-gray-600">Dựa trên dữ liệu lịch sử xổ số để đưa ra thống kê chính xác</p>
                    </div>

                    <div class="text-center p-6 bg-gradient-to-r from-purple-50 to-purple-100 rounded-xl">
                        <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Giải mã giấc mơ</h3>
                        <p class="text-gray-600">Phân tích và chuyển đổi giấc mơ thành những con số may mắn</p>
                    </div>

                    <div class="text-center p-6 bg-gradient-to-r from-green-50 to-green-100 rounded-xl">
                        <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Dự đoán thông minh</h3>
                        <p class="text-gray-600">Kết hợp AI và kinh nghiệm để dự đoán xu hướng</p>
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
                        <strong>Phân tích xổ số:</strong> Chọn các con số từ 00 đến 99 để phân tích thống kê và xu hướng.
                        <br>
                        <strong>Phân tích giấc mơ:</strong> Mô tả chi tiết giấc mơ của bạn để hệ thống giải mã và đưa ra những con số may mắn.
                    </p>
                </div>
            </div>
        </div>

        <!-- Analysis Result Section -->
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
                                <span id="analysis-type">Đã phân tích:</span>
                                <span id="selected-content" class="font-semibold text-blue-600">888</span>
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

        <!-- Main Analysis Section -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <!-- Tab Navigation -->
            <div class="text-center mb-8">
                <h3 class="text-2xl font-bold text-gray-800 mb-6">Chọn loại phân tích</h3>

                <div class="flex justify-center mb-6">
                    <div class="flex items-center space-x-2 bg-gray-100 rounded-lg p-1">
                        <button id="lottery-tab"
                            class="tab-btn px-6 py-3 rounded-md text-sm font-medium transition-all duration-200 bg-blue-500 text-white shadow-md">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                    </path>
                                </svg>
                                <span>Phân tích xổ số</span>
                            </div>
                        </button>
                        <button id="dream-tab"
                            class="tab-btn px-6 py-3 rounded-md text-sm font-medium transition-all duration-200 text-gray-600 hover:text-gray-800 hover:bg-gray-50">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                                </svg>
                                <span>Giải mã giấc mơ</span>
                            </div>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Lottery Analysis Content -->
            <div id="lottery-content" class="tab-content">
                <div class="text-center mb-6">
                    <p class="text-gray-600">Chọn số để phân tích thống kê, tần suất xuất hiện và dự đoán xu hướng</p>
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

                <!-- Number Grid -->
                <div class="grid grid-cols-5 sm:grid-cols-10 gap-3 max-w-4xl mx-auto">
                    <!-- Numbers 00-99 will be generated by JavaScript -->
                </div>
            </div>

            <!-- Dream Analysis Content -->
            <div id="dream-content" class="tab-content hidden">
                <div class="max-w-3xl mx-auto">
                    <div class="text-center mb-8">
                        <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                            </svg>
                        </div>
                        <p class="text-gray-600 text-lg">Hãy mô tả chi tiết giấc mơ của bạn để chúng tôi giải mã và đưa ra những con số may mắn</p>
                    </div>

                    <div class="space-y-6">
                        <!-- Dream Input Form -->
                        <div class="bg-gradient-to-r from-purple-50 to-indigo-50 rounded-xl p-6 border border-purple-200">
                            <label for="dream-input" class="block text-lg font-semibold text-gray-800 mb-3">
                                <span class="flex items-center">
                                    <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                    </svg>
                                    Mô tả giấc mơ của bạn
                                </span>
                            </label>
                            <textarea
                                id="dream-input"
                                rows="6"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 resize-none"
                                placeholder="Ví dụ: Tôi mơ thấy một con rồng vàng bay trên bầu trời xanh, sau đó nó hạ cánh xuống một cái ao có nhiều hoa sen trắng nở rộ. Trong mơ tôi cảm thấy rất bình yên và may mắn..."
                                maxlength="2000"></textarea>
                            <div class="flex justify-between items-center mt-3">
                                <span class="text-sm text-gray-500">
                                    <span id="char-count">0</span>/2000 ký tự
                                </span>
                                <span class="text-xs text-purple-600">Mô tả càng chi tiết, kết quả càng chính xác</span>
                            </div>
                        </div>

                        <!-- Dream Categories (Optional) -->
                        <div class="bg-gray-50 rounded-xl p-6">
                            <h4 class="text-md font-semibold text-gray-800 mb-4">Thể loại giấc mơ (tùy chọn)</h4>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="checkbox" value="animals" class="dream-category text-purple-600 focus:ring-purple-500">
                                    <span class="text-sm text-gray-700">Động vật</span>
                                </label>
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="checkbox" value="nature" class="dream-category text-purple-600 focus:ring-purple-500">
                                    <span class="text-sm text-gray-700">Thiên nhiên</span>
                                </label>
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="checkbox" value="people" class="dream-category text-purple-600 focus:ring-purple-500">
                                    <span class="text-sm text-gray-700">Con người</span>
                                </label>
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="checkbox" value="objects" class="dream-category text-purple-600 focus:ring-purple-500">
                                    <span class="text-sm text-gray-700">Đồ vật</span>
                                </label>
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="checkbox" value="places" class="dream-category text-purple-600 focus:ring-purple-500">
                                    <span class="text-sm text-gray-700">Địa điểm</span>
                                </label>
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="checkbox" value="emotions" class="dream-category text-purple-600 focus:ring-purple-500">
                                    <span class="text-sm text-gray-700">Cảm xúc</span>
                                </label>
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="checkbox" value="supernatural" class="dream-category text-purple-600 focus:ring-purple-500">
                                    <span class="text-sm text-gray-700">Siêu nhiên</span>
                                </label>
                                <label class="flex items-center space-x-2 cursor-pointer">
                                    <input type="checkbox" value="activities" class="dream-category text-purple-600 focus:ring-purple-500">
                                    <span class="text-sm text-gray-700">Hoạt động</span>
                                </label>
                            </div>
                        </div>

                        <!-- Analyze Dream Button -->
                        <div class="text-center">
                            <button id="analyze-dream-btn"
                                class="px-8 py-4 bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700 text-white font-semibold rounded-lg shadow-lg transform transition-all duration-200 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                                disabled>
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    <span>Giải mã giấc mơ</span>
                                </div>
                            </button>
                        </div>

                        <!-- Dream Examples -->
                        <div class="bg-yellow-50 rounded-xl p-6 border border-yellow-200">
                            <h5 class="text-sm font-semibold text-yellow-800 mb-3 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                </svg>
                                Một số ví dụ về giấc mơ phổ biến:
                            </h5>
                            <div class="text-sm text-yellow-700 space-y-2">
                                <p><strong>• Mơ thấy nước:</strong> Ao hồ trong xanh, sông chảy xiết, biển cả bao la...</p>
                                <p><strong>• Mơ thấy động vật:</strong> Rồng vàng, phượng hoàng, cá chép, rắn, hổ, voi...</p>
                                <p><strong>• Mơ thấy người thân:</strong> Ông bà tổ tiên, bố mẹ, anh chị em, bạn bè...</p>
                                <p><strong>• Mơ thấy cây cối:</strong> Cây đa, cây sung, hoa sen, hoa đào, trái cây...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.getElementById('current-date').textContent = new Date().toLocaleDateString('vi-VN');

        let selectionMode = 'single';
        let selectedNumbers = new Set();
        let currentTab = 'lottery';

        // Initialize number grid
        const numberGrid = document.querySelector('.grid.grid-cols-5');
        for (let i = 0; i <= 99; i++) {
            const number = i.toString().padStart(2, '0');
            const button = document.createElement('button');
            button.className = 'number-btn bg-primary-gradient hover:from-blue-600 hover:to-purple-700 text-white font-bold py-1 px-1 rounded-lg shadow-md';
            button.textContent = number;
            button.dataset.number = number;
            button.addEventListener('click', () => handleNumberClick(number, button));
            numberGrid.appendChild(button);
        }

        // Tab switching
        document.getElementById('lottery-tab').addEventListener('click', () => switchTab('lottery'));
        document.getElementById('dream-tab').addEventListener('click', () => switchTab('dream'));

        // Lottery mode switching
        document.getElementById('single-mode-btn').addEventListener('click', () => switchMode('single'));
        document.getElementById('multi-mode-btn').addEventListener('click', () => switchMode('multi'));

        // Lottery controls
        document.getElementById('select-all-btn').addEventListener('click', selectAll);
        document.getElementById('clear-all-btn').addEventListener('click', clearAll);
        document.getElementById('analyze-multi-btn').addEventListener('click', analyzeMultipleNumbers);

        // Dream analysis
        const dreamInput = document.getElementById('dream-input');
        const analyzeDreamBtn = document.getElementById('analyze-dream-btn');
        const charCount = document.getElementById('char-count');

        dreamInput.addEventListener('input', () => {
            const text = dreamInput.value;
            charCount.textContent = text.length;
            analyzeDreamBtn.disabled = text.trim().length < 10;
        });

        analyzeDreamBtn.addEventListener('click', analyzeDream);

        // Navigation
        document.getElementById('back-btn').addEventListener('click', () => {
            document.getElementById('analysis-section').classList.add('hidden');
            document.getElementById('intro-section').classList.remove('hidden');
        });

        function switchTab(tab) {
            currentTab = tab;

            // Update tab buttons
            if (tab === 'lottery') {
                document.getElementById('lottery-tab').className = 'tab-btn px-6 py-3 rounded-md text-sm font-medium transition-all duration-200 bg-blue-500 text-white shadow-md';
                document.getElementById('dream-tab').className = 'tab-btn px-6 py-3 rounded-md text-sm font-medium transition-all duration-200 text-gray-600 hover:text-gray-800 hover:bg-gray-50';

                document.getElementById('lottery-content').classList.remove('hidden');
                document.getElementById('dream-content').classList.add('hidden');
            } else {
                document.getElementById('dream-tab').className = 'tab-btn px-6 py-3 rounded-md text-sm font-medium transition-all duration-200 bg-purple-500 text-white shadow-md';
                document.getElementById('lottery-tab').className = 'tab-btn px-6 py-3 rounded-md text-sm font-medium transition-all duration-200 text-gray-600 hover:text-gray-800 hover:bg-gray-50';

                document.getElementById('dream-content').classList.remove('hidden');
                document.getElementById('lottery-content').classList.add('hidden');
            }
        }

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
            await analyzeNumbers(numbersArray, 'lottery');
        }

        async function analyzeNumber(number) {
            await analyzeNumbers([number], 'lottery');
        }

        async function analyzeDream() {
            const dreamText = dreamInput.value.trim();
            if (dreamText.length < 10) return;

            const selectedCategories = Array.from(document.querySelectorAll('.dream-category:checked'))
                .map(cb => cb.value);

            await analyzeDreamContent(dreamText, selectedCategories);
        }

        async function analyzeDreamContent(dreamText, categories) {
            window.scrollTo({ top: 0, behavior: 'smooth' });
            document.getElementById('intro-section').classList.add('hidden');
            document.getElementById('analysis-section').classList.remove('hidden');

            document.getElementById('analysis-type').textContent = 'Giấc mơ đã phân tích:';
            document.getElementById('selected-content').textContent = dreamText.substring(0, 100) + '...';
            document.getElementById('analysis-time').textContent = new Date().toLocaleTimeString('vi-VN');

            document.getElementById('loading-state').classList.remove('hidden');
            document.getElementById('analysis-content').classList.add('hidden');

            try {
                const response = await fetch(`{{ route('ai-analytic') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        type: 'dream',
                        content: dreamText,
                        categories: categories
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
                console.error('Error fetching dream analysis:', error);
                showError('Giấc mơ của bạn');
            }
        }

        async function analyzeNumbers(numbersArray, type) {
            window.scrollTo({ top: 0, behavior: 'smooth' });
            document.getElementById('intro-section').classList.add('hidden');
            document.getElementById('analysis-section').classList.remove('hidden');

            if (numbersArray.length === 1) {
                document.getElementById('analysis-type').textContent = 'Số đã chọn:';
                document.getElementById('selected-content').textContent = numbersArray[0];
            } else {
                document.getElementById('analysis-type').textContent = 'Các số đã chọn:';
                document.getElementById('selected-content').textContent = numbersArray.join(', ');
            }
            document.getElementById('analysis-time').textContent = new Date().toLocaleTimeString('vi-VN');

            document.getElementById('loading-state').classList.remove('hidden');
            document.getElementById('analysis-content').classList.add('hidden');

            try {
                const response = await fetch(`{{ route('ai-analytic') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        type: 'lottery',
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

        function showError(content) {
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

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
@endsection
