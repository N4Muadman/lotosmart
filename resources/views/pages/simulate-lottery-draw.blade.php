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
                    <h2 class="text-lg font-semibold"><i class="fas fa-broadcast-tower"></i> Quay thử kết quả xổ số hôm nay</h2>
                </div>
                <div class="flex justify-end gap-4">
                    <select id="filter-region" class="filter-input border rounded px-2 py-1 text-black">
                        <option value="XSMB">Miền Bắc</option>
                        <option value="XSMT">Miền Trung</option>
                        <option value="XSMN">Miền Nam</option>
                    </select>
                    <button class="btn btn-primary">Quay thử</button>

                </div>
            </div>

            <div id="ticker-content" class="ticker-content grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Lottery Results and Statistics will be dynamically inserted here -->
            </div>


            <div id="ai-prediction">

            </div>

        </section>
    </div>

    <script></script>
@endsection
