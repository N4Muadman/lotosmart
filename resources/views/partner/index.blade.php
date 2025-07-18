@extends('layout')

@section('content')
    <style>
        body {
            font-family: 'Be Vietnam Pro', sans-serif;
            background-color: rgb(219, 235, 231);
        }
        .gradient-text {
            background: linear-gradient(90deg, #0284c7, #7c3aed);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
         .faq-question:focus {
            outline: none !important;
            box-shadow: none !important;
            border: none !important;
        }
    </style>

<body class="text-gray-800">

    <main>
        <section class="py-20 text-center">
            <div class="container mx-auto px-6">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">
                    Đồng hành cùng 630.vn
                </h1>
                <p class="text-lg mb-8 max-w-3xl mx-auto">
                    Kiến tạo tương lai của ngành phân tích dữ liệu xổ số bằng Trí Tuệ Nhân Tạo. Chúng tôi cần sự chung tay của bạn để biến những thuật toán phức tạp thành công cụ hữu ích cho cộng đồng.
                </p>
                <a href="#goi-tai-tro" class="btn btn-primary bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
                    Chọn Gói Tài Trợ
                </a>
            </div>
        </section>

        <section id="cong-nghe" class="py-20 bg-white/50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold">Công Nghệ Cốt Lõi</h2>
                    <p class="text-lg mb-8 mt-2">Sức mạnh đằng sau những con số của 630.vn</p>
                </div>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="bg-white p-6 rounded-xl border border-gray-300">
                        <h3 class="text-xl font-bold md:text-1xl mb-2">Dự Đoán AI Đa Mô Hình</h3>
                        <p class="text-gray-600 text-sm md:text-base leading-relaxed text-justify">
                            Sử dụng XGBoost, Random Forest và mạng LSTM để phân tích dữ liệu lịch sử, nhận diện các mẫu hình và dự đoán chuỗi thời gian với độ chính xác cao.
                        </p>
                    </div>
                    <div class="bg-white p-6 rounded-xl border border-gray-300">
                        <h3 class="text-xl font-bold md:text-1xl mb-2">AI Phân Bổ Vốn</h3>
                        <p class="text-gray-600 text-sm md:text-base leading-relaxed text-justify">Không chỉ đưa ra con số, AI của chúng tôi còn gợi ý chiến lược tài chính thông minh, giúp người dùng tối ưu hóa cách phân bổ vốn dựa trên mức độ rủi ro.</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl border border-gray-300">
                        <h3 class="text-xl font-bold md:text-1xl mb-2">Hạ Tầng Mạnh Mẽ</h3>
                        <p class="text-gray-600 text-sm md:text-base leading-relaxed text-justify">Được xây dựng trên nền tảng vững chắc, hệ thống của chúng tôi đảm bảo tốc độ xử lý siêu nhanh và hoạt động ổn định liên tục.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="goi-tai-tro" class="py-20">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold">Các Gói Tài Trợ</h2>
                    <p class="text-lg mb-8 mt-2">Mọi sự đóng góp đều là nguồn động lực to lớn cho dự án.</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8 mb-12">
                    <div class="dashboard-card bg-white shadow rounded-lg p-6">
                        <h3 class="text-2xl font-bold text-center mb-2">Đồng Hành</h3>
                        <p class="text-4xl font-bold text-center mb-6">500K<span class="text-lg font-normal text-gray-600"> VNĐ</span></p>
                        <ul class="space-y-3 text-gray-600">
                            <li>✓ Tên bạn được vinh danh tại "Bức Tường Tri Ân"</li>
                            <li>✓ Nhận tin tức cập nhật độc quyền về dự án</li>
                            <li>✓ Huy hiệu "Người Đồng Hành" trên profile (khi ra mắt)</li>
                        </ul>
                        <div class="text-center mt-6">
                            <a href="#contact" class="inline-block bg-emerald-500 text-white py-2 px-6 min-w-[150px] rounded hover:bg-emerald-600 transition">Liên hệ ngay</a>
                        </div>
                    </div>

                    <div class="dashboard-card bg-white shadow rounded-lg p-6">
                        <div class="text-center -mt-12 mb-4">
                            <span class="bg-emerald-600 text-white text-sm font-bold px-4 py-1 rounded-full">Phổ Biến Nhất</span>
                        </div>
                        <h3 class="text-2xl font-bold text-center mb-2">Tiên Phong</h3>
                        <p class="text-4xl font-bold text-center mb-6">2M<span class="text-lg font-normal text-gray-600"> VNĐ</span></p>
                        <ul class="space-y-3 text-gray-600">
                            <li>✓ Mọi quyền lợi của gói Đồng Hành</li>
                            <li>✓ <strong>1 tháng</strong> sử dụng gói VIP 1 khi ứng dụng ra mắt</li>
                            <li>✓ Tham gia vào kênh Discord/Zalo riêng cho nhà tài trợ</li>
                        </ul>
                        <div class="text-center mt-6">
                            <a href="#contact" class="inline-block bg-emerald-500 text-white py-2 px-6 min-w-[150px] rounded hover:bg-emerald-600 transition">Liên hệ ngay</a>
                        </div>
                    </div>

                    <div class="dashboard-card bg-white shadow rounded-lg p-6">
                        <h3 class="text-2xl font-bold text-center mb-2">Chiến Lược</h3>
                        <p class="text-4xl font-bold text-center mb-6">5M<span class="text-lg font-normal text-gray-600"> VNĐ</span></p>
                        <ul class="space-y-3 text-gray-600">
                            <li>✓ Mọi quyền lợi của gói Tiên Phong</li>
                            <li>✓ <strong>1 tháng</strong> sử dụng gói VIP 2 khi ứng dụng ra mắt</li>
                            <li>✓ Mention đặc biệt trong buổi Livestream ra mắt sản phẩm</li>
                        </ul>
                        <div class="text-center mt-6">
                            <a href="#contact" class="inline-block bg-emerald-500 text-white py-2 px-6 min-w-[150px] rounded hover:bg-emerald-600 transition">Liên hệ ngay</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="lo-trinh" class="py-20 bg-white/50">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold">Mô Hình Hợp Tác & Tài Trợ</h2>
                    <p class="text-lg mb-8 mt-2">Sự đồng hành của các đối tác và nhà tài trợ sẽ giúp chúng tôi phát triển mạnh mẽ, bền vững hơn qua các mô hình hợp tác linh hoạt này</p>
                </div>
                <div class="relative max-w-2xl mx-auto">
                    <div class="absolute left-1/2 -translate-x-1/2 h-full w-0.5 bg-gray-300"></div>

                    <div class="relative mb-8">
                        <div class="absolute left-1/2 -translate-x-1/2 mt-2 w-4 h-4 bg-gray-500 rounded-full ring-4 ring-white"></div>
                        <div class="w-full text-center md:w-1/2 md:pr-8 md:text-right">
                            <h3 class="text-xl font-bold mt-1"> Hợp tác Nội dung & Công nghệ</h3>
                            <p class="text-gray-600">Cùng sáng tạo nội dung và tích hợp giải pháp công nghệ để nâng cao giá trị cho cả hai bên.</p>
                        </div>
                    </div>

                    <div class="relative mb-8 flex justify-end">
                        <div class="absolute left-1/2 -translate-x-1/2 mt-2 w-4 h-4 bg-gray-500 rounded-full ring-4 ring-white"></div>
                        <div class="w-full text-center md:w-1/2 md:pl-8 md:text-left">
                            <h3 class="text-xl font-bold mt-1">Hợp tác Marketing & Kinh doanh</h3>
                            <p class="text-gray-600">Phối hợp truyền thông, tổ chức sự kiện và phân phối sản phẩm nhằm mở rộng thị trường, tăng trưởng doanh thu.</p>
                        </div>
                    </div>

                    <div class="relative mb-8">
                        <div class="absolute left-1/2 -translate-x-1/2 mt-2 w-4 h-4 bg-gray-500 rounded-full ring-4 ring-white"></div>
                        <div class="w-full text-center md:w-1/2 md:pr-8 md:text-right">
                            <h3 class="text-xl font-bold mt-1">Hợp tác Đầu tư & Tài chính</h3>
                            <p class="text-gray-600">Kêu gọi đầu tư, tài trợ dự án với cam kết đồng hành phát triển bền vững và chia sẻ lợi ích.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="faq" class="py-20">
            <div class="container mx-auto px-6 max-w-3xl">
                <div class="text-center mb-12">
                    <h2 class="text-3xl md:text-4xl font-bold">Câu Hỏi Thường Gặp</h2>
                </div>
                <div class="space-y-4">
                    <div class="faq-item bg-white rounded-lg">
                        <button class="faq-question w-full flex justify-between items-center text-left p-6 focus:outline-none">
                            <span class="text-lg font-semibold">Dự án này có hợp pháp không?</span>
                            <svg class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div class="faq-answer hidden p-6 pt-0 text-gray-600">
                            <p>Hoàn toàn hợp pháp. <strong>630.vn không phải là ứng dụng cờ bạc và không tổ chức cá cược.</strong> Chúng tôi hoạt động dưới mô hình công ty công nghệ, chuyên cung cấp dịch vụ phân tích dữ liệu và thống kê xác suất dựa trên dữ liệu xổ số công khai, hợp pháp của nhà nước.</p>
                        </div>
                    </div>
                    <div class="faq-item bg-white rounded-lg">
                        <button class="faq-question w-full flex justify-between items-center text-left p-6 focus:outline-none">
                            <span class="text-lg font-semibold">Ứng dụng có cam kết trúng 100% không?</span>
                            <svg class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        <div class="faq-answer hidden p-6 pt-0 text-gray-600">
                            <p><strong>Không.</strong> Chúng tôi không cam kết và không thể cam kết tỷ lệ trúng. AI chỉ là công cụ phân tích để đưa ra những con số có xác suất về cao nhất dựa trên dữ liệu lịch sử. Mọi quyết định cuối cùng đều thuộc về người dùng và chúng tôi không khuyến khích các hành vi cờ bạc.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // --- FAQ Accordion Logic ---
        const faqItems = document.querySelectorAll('.faq-item');
        faqItems.forEach(item => {
            const question = item.querySelector('.faq-question');
            const answer = item.querySelector('.faq-answer');
            const icon = question.querySelector('svg');

            question.addEventListener('click', () => {
                faqItems.forEach(i => {
                    if (i !== item) {
                        i.querySelector('.faq-answer').classList.add('hidden');
                        i.querySelector('svg').classList.remove('rotate-180');
                    }
                });
                answer.classList.toggle('hidden');
                icon.classList.toggle('rotate-180');
            });
        });
    });
</script>

</body>

@endsection
