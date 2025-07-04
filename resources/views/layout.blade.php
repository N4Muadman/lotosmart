<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LotoSmart Analytics - Phân tích thông minh, Quyết định sáng suốt</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
    <!-- Header -->
    <header class="header">
        <div class="nav-container">
            <div class="logo">
                <i class="fas fa-chart-line"></i>
                <span>LotoSmart</span>
            </div>
            <nav class="nav-menu">
                <li><a href="{{route('home')}}">Trang chủ</a></li>
                <li><a href="#analysis">Phân tích</a></li>
                <li><a href="#predictions">Dự đoán AI</a></li>
                <li><a href="#community">Cộng đồng</a></li>
                <li><a href="#tools">Công cụ</a></li>
            </nav>
            <div class="auth-buttons">
                <a href="#login" class="btn btn-secondary">Đăng nhập</a>
                <a href="#register" class="btn btn-primary">Đăng ký</a>
            </div>
            <div class="mobile-menu-toggle" id="mobileMenuToggle">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </header>

    <main class="main-content">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>Sản phẩm</h3>
                <a href="#">Dashboard Analytics</a>
                <a href="#">AI Predictions</a>
                <a href="#">Mobile App</a>
                <a href="#">API Developer</a>
            </div>
            <div class="footer-section">
                <h3>Tính năng</h3>
                <a href="#">Phân tích thống kê</a>
                <a href="#">Dự đoán AI</a>
                <a href="#">Báo cáo tùy chỉnh</a>
                <a href="#">Cộng đồng</a>
            </div>
            <div class="footer-section">
                <h3>Hỗ trợ</h3>
                <a href="#">Trung tâm trợ giúp</a>
                <a href="#">Hướng dẫn sử dụng</a>
                <a href="#">Liên hệ</a>
                <a href="#">FAQ</a>
            </div>
            <div class="footer-section">
                <h3>Pháp lý</h3>
                <a href="#">Điều khoản sử dụng</a>
                <a href="#">Chính sách bảo mật</a>
                <a href="#">Trách nhiệm</a>
                <a href="#">Cookie Policy</a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 LotoSmart Analytics. Tất cả quyền được bảo lưu. | Phân tích thông minh - Quyết định sáng suốt
            </p>
        </div>
    </footer>

    <!-- AI Chatbot -->
    <div class="chatbot-container" id="chatbot">
        <div class="chatbot-header">
            <i class="fas fa-robot"></i>
            <span>AI Assistant</span>
            <button class="chatbot-close" id="chatbotClose">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="chatbot-messages" id="chatbotMessages">
            <div class="bot-message">
                <div class="message-avatar">
                    <i class="fas fa-robot"></i>
                </div>
                <div class="message-content">
                    Xin chào! Tôi là AI Assistant của LotoSmart. Tôi có thể giúp bạn phân tích dữ liệu và đưa ra dự đoán
                    thông minh. Bạn cần hỗ trợ gì?
                </div>
            </div>
        </div>
        <div class="chatbot-input">
            <input type="text" id="chatbotInput" placeholder="Nhập câu hỏi của bạn...">
            <button id="chatbotSend">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>

    <!-- Chatbot Toggle Button -->
    <button class="chatbot-toggle" id="chatbotToggle">
        <i class="fas fa-comment"></i>
    </button>

    <!-- Notification Toast -->
    <div class="toast-container" id="toastContainer"></div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            initializeChatbot();
            initializeMobileMenu();
        })

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

    </script>

</body>

</html>
