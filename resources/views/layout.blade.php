<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow">
    <title>630.vn | @yield('title', 'Dự Đoán Lô Đề Chuẩn AI – Phân Tích Xổ Số Chính Xác Nhất')</title>
    <meta name="description" content="630.vn: Nền tảng dự đoán lô đề AI hàng đầu, phân tích dữ liệu xổ số và đưa ra 10 số có tỷ lệ về cao nhất. Tối ưu chiến lược vốn với AI tài chính. Tăng cơ hội trúng lớn ngay hôm nay!">
    <meta name="keywords" content="dự đoán lô đề, dự đoán lô đề AI, lô đề chuẩn AI, xổ số AI, phân tích xổ số, số đẹp hôm nay, soi cầu AI, 630vn, dự đoán xổ số miền Bắc, dự đoán xổ số miền Nam, dự đoán xổ số miền Trung, AI tài chính, tối ưu vốn lô đề, xsmb, xsmn, xsmt,xổ số miền bắc, xổ số miền nam, xổ số miền trung">
    <link rel="canonical" href="{{url('/')}}">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{url('/')}}">
    <meta property="og:title" content="630.vn | Dự Đoán Lô Đề Chuẩn AI – Phân Tích Xổ Số Chính Xác Nhất">
    <meta property="og:description" content="630.vn: Nền tảng dự đoán lô đề AI hàng đầu, phân tích dữ liệu xổ số và đưa ra 10 số có tỷ lệ về cao nhất. Tối ưu chiến lược vốn với AI tài chính. Tăng cơ hội trúng lớn ngay hôm nay!">
    <meta property="og:image" content="{{url('/')}}/logo-630vn-share.png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{url('/')}}">
    <meta name="twitter:title" content="630.vn | Dự Đoán Lô Đề Chuẩn AI – Phân Tích Xổ Số Chính Xác Nhất">
    <meta name="twitter:description" content="630.vn: Nền tảng dự đoán lô đề AI hàng đầu, phân tích dữ liệu xổ số và đưa ra 10 số có tỷ lệ về cao nhất. Tối ưu chiến lược vốn với AI tài chính. Tăng cơ hội trúng lớn ngay hôm nay!">
    <meta name="twitter:image" content="{{url('/')}}/logo-630vn-share.png">

    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>
    <!-- Header -->
    <header class="header">
        <div class="nav-container">
            <div class="logo">
                <a href="{{ route('pages.home') }}">
                    <i class="fas fa-chart-line"></i>
                    <span>630 AI</span>
                </a>
            </div>
            <nav class="nav-menu">
                <li><a href="{{ route('pages.analytic') }}" class="w-full block">Phân tích</a></li>
                <li><a href="#predictions" class="chatbot-toggle-btn w-full block">Dự đoán AI</a></li>
                <li><a href="{{ route('news.index') }}" class="w-full block">Tin tức</a></li>
                <li><a href="{{ route('partner.index') }}" class="w-full block">Đối tác</a></li>
                <li class="flex gap-3 justify-center block md:hidden">
                    <a href="#login" class="btn btn-secondary">Đăng nhập</a>
                    <a href="#register" class="btn btn-primary">Đăng ký</a>
                </li>
            </nav>
            <div class="hidden md:block">
                <div class="auth-buttons ">
                    <a href="#login" class="btn btn-secondary">Đăng nhập</a>
                    <a href="#register" class="btn btn-primary">Đăng ký</a>
                </div>
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
        {{-- <div class="footer-content">
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
        </div> --}}
        <div class="footer-bottom">
            <p>&copy; 2024 630 AI dự đoán. Tất cả quyền được bảo lưu. | Phân tích thông minh - Quyết định sáng suốt
            </p>
        </div>
    </footer>

    <div class="chatbot-container" id="chatbot">
        <div class="chatbot-header">
            <i class="fas fa-robot"></i>
            <span>AI 630</span>
            <button class="chatbot-close" id="chatbotClose">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="chatbot-messages" id="chatbotMessages">
            <!-- Messages will be loaded here -->
        </div>
        <div class="chatbot-input">
            <input type="text" id="chatbotInput" placeholder="Nhập câu hỏi của bạn...">
            <button id="chatbotSend">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>

    <!-- Chatbot Toggle Button -->
    <button class="chatbot-toggle chatbot-toggle-btn" id="chatbotToggle">
        <i class="fas fa-comment"></i>
    </button>

    <!-- Notification Toast -->
    <div class="toast-container" id="toastContainer"></div>

    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            initializeChatbot();
            initializeMobileMenu();
        })

        let chatHistory = [];
        let dataConversation = [];

        // Load chat history from storage
        function loadChatHistory() {
            try {
                const stored = sessionStorage.getItem('chatHistory');
                const conversation = sessionStorage.getItem('dataConversation');
                if (stored) {
                    chatHistory = JSON.parse(stored);
                }

                if (conversation) {
                    dataConversation = JSON.parse(conversation);
                }

            } catch (e) {
                // If storage fails, use in-memory storage
                chatHistory = [];
                conversation = [];
            }
        }

        // Save chat history to storage
        function saveChatHistory() {
            try {
                sessionStorage.setItem('chatHistory', JSON.stringify(chatHistory));
                sessionStorage.setItem('dataConversation', JSON.stringify(dataConversation));
            } catch (e) {
                // If storage fails, just keep in memory
                console.log('Storage not available, using in-memory storage');
            }
        }

        const suggestions = [
            "Phân tích số may mắn hôm nay",
            "Dự đoán XSMB ngày mai",
            "Tư vấn cầu lô gan lâu",
            "Xu hướng số đề tuần này",
            "Thống kê tần suất xuất hiện"
        ];

        function initializeChatbot() {
            const chatbotToggles = document.querySelectorAll('.chatbot-toggle-btn');
            const chatbotContainer = document.getElementById('chatbot');
            const chatbotClose = document.getElementById('chatbotClose');
            const chatbotSend = document.getElementById('chatbotSend');
            const chatbotInput = document.getElementById('chatbotInput');
            const chatbotMessages = document.getElementById('chatbotMessages');

            loadChatHistory();
            displayChatHistory();

            chatbotToggles.forEach(element => {
                element.addEventListener('click', () => {
                    chatbotContainer.style.display = chatbotContainer.style.display === 'flex' ? 'none' :
                        'flex';
                    if (chatbotContainer.style.display === 'flex') {
                        chatbotInput.focus();

                        chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
                    }
                });
            });

            chatbotClose.addEventListener('click', () => {
                chatbotContainer.style.display = 'none';
            });

            function displayChatHistory() {
                chatbotMessages.innerHTML = '';

                if (chatHistory.length === 0) {
                    const welcomeMessage = {
                        message: "Xin chào! Tôi là AI dự đoán của 630. Tôi có thể giúp bạn phân tích dữ liệu và đưa ra dự đoán thông minh. Bạn cần hỗ trợ gì?",
                        sender: 'bot',
                        timestamp: new Date().toISOString()
                    };
                    addMessageToDOM(welcomeMessage);
                    showSuggestions();
                } else {
                    chatHistory.forEach(msg => {
                        addMessageToDOM(msg);
                    });

                    chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
                }
            }

            function showSuggestions() {
                const suggestionsContainer = document.createElement('div');
                suggestionsContainer.className = 'suggestions';
                suggestionsContainer.innerHTML =
                    '<div style="font-size: 0.8rem; color: var(--text-secondary); margin-bottom: 0.5rem;">Gợi ý câu hỏi:</div>';

                suggestions.forEach(suggestion => {
                    const suggestionItem = document.createElement('div');
                    suggestionItem.className = 'suggestion-item';
                    suggestionItem.textContent = suggestion;
                    suggestionItem.addEventListener('click', () => {
                        chatbotInput.value = suggestion;
                        sendMessage();
                    });
                    suggestionsContainer.appendChild(suggestionItem);
                });

                chatbotMessages.appendChild(suggestionsContainer);
                chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
            }

            function removeSuggestions() {
                const suggestions = chatbotMessages.querySelector('.suggestions');
                if (suggestions) {
                    suggestions.remove();
                }
            }

            function sendMessage() {
                const message = chatbotInput.value.trim();
                if (message && !chatbotSend.disabled) {
                    removeSuggestions();

                    const userMessage = {
                        message: message,
                        sender: 'user',
                        timestamp: new Date().toISOString()
                    };

                    chatHistory.push(userMessage);
                    dataConversation.push(userMessage);
                    addMessageToDOM(userMessage);
                    saveChatHistory();

                    chatbotInput.value = '';
                    chatbotSend.disabled = true;

                    showTypingIndicator();

                    fetch('{{ route('ai-chat-bot') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                // 'Authorization': 'Bearer your-token-here'
                            },
                            body: JSON.stringify({
                                conversation: chatHistory
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            const botMessageDOM = {
                                message: marked.parse(data.message),
                                sender: 'bot',
                                timestamp: new Date().toISOString()
                            };

                            const botMessage = {
                                message: data.message,
                                sender: 'bot',
                                timestamp: new Date().toISOString()
                            };

                            chatHistory.push(botMessageDOM);
                            dataConversation.push(botMessage);

                            addMessageToDOM(botMessageDOM);
                            saveChatHistory();
                        })
                        .catch(error => {
                            console.error('Lỗi:', error);
                        }).finally(() => {
                            hideTypingIndicator();
                            chatbotSend.disabled = false;
                            chatbotInput.focus();
                        });
                }
            }

            function addMessageToDOM(messageObj) {
                const messageDiv = document.createElement('div');
                messageDiv.className = `${messageObj.sender}-message`;
                messageDiv.innerHTML = `
                    <div class="message-avatar">
                        <i class="fas fa-${messageObj.sender === 'user' ? 'user' : 'robot'}"></i>
                    </div>
                    <div class="message-content">${messageObj.message}</div>
                `;
                chatbotMessages.appendChild(messageDiv);
                chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
            }

            function showTypingIndicator() {
                const typingDiv = document.createElement('div');
                typingDiv.className = 'typing-indicator';
                typingDiv.id = 'typingIndicator';
                typingDiv.innerHTML = `
                    <div class="message-avatar">
                        <i class="fas fa-robot"></i>
                    </div>
                    <div class="typing-dots">
                        <div class="typing-dot"></div>
                        <div class="typing-dot"></div>
                        <div class="typing-dot"></div>
                    </div>
                `;
                chatbotMessages.appendChild(typingDiv);
                chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
            }

            function hideTypingIndicator() {
                const typingIndicator = document.getElementById('typingIndicator');
                if (typingIndicator) {
                    typingIndicator.remove();
                }
            }

            // Event listeners
            chatbotSend.addEventListener('click', sendMessage);
            chatbotInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter' && !chatbotSend.disabled) {
                    sendMessage();
                }
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
