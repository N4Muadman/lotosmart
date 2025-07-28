const WebSocket = require('ws');
const fetch = require('node-fetch');

const LARAVEL_API_URL = 'https://petshoptuananh.store/api/new-lottery-results';

let ws = null;
let reconnectAttempts = 0;
const maxReconnectAttempts = 5;
const reconnectDelay = 30000;
let reconnectTimer = null;

function isLotteryTime() {
    const vietnamTime = new Date().toLocaleString('en-US', { timeZone: 'Asia/Ho_Chi_Minh' });
    const hour = new Date(vietnamTime).getHours();
    return hour >= 16 && hour < 19;
}

function getTimeToNextLottery() {
    const vietnamTime = new Date().toLocaleString('en-US', { timeZone: 'Asia/Ho_Chi_Minh' });
    const now = new Date(vietnamTime);
    const currentHour = now.getHours();

    let nextLotteryTime = new Date(now);

    if (currentHour < 16) {
        nextLotteryTime.setHours(16, 0, 0, 0);
    } else if (currentHour >= 19) {
        nextLotteryTime.setDate(nextLotteryTime.getDate() + 1);
        nextLotteryTime.setHours(16, 0, 0, 0);
    } else {
        return 0;
    }

    return nextLotteryTime.getTime() - now.getTime();
}

function connectWebSocket() {
    if (!isLotteryTime()) {
        const timeToNext = getTimeToNextLottery();
        const hours = Math.floor(timeToNext / (1000 * 60 * 60));
        const minutes = Math.floor((timeToNext % (1000 * 60 * 60)) / (1000 * 60));

        console.log(`⏰ Hiện tại không phải khung giờ xổ số (16:00-19:00)`);
        console.log(`⏰ Sẽ thử kết nối lại sau ${hours}h ${minutes}m`);

        setTimeout(() => {
            connectWebSocket();
        }, Math.min(timeToNext, 1800000)); // Tối đa 30 phút

        return;
    }

    try {
        console.log(`🔄 Đang kết nối WebSocket... (Lần thử: ${reconnectAttempts + 1})`);

        ws = new WebSocket('wss://livexs.xoso.com.vn/', {
            headers: {
                'Origin': 'https://xoso.com.vn',
                'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
                'Accept-Language': 'vi-VN,vi;q=0.9,en;q=0.8',
                'Cache-Control': 'no-cache',
                'Pragma': 'no-cache',
                'Sec-WebSocket-Extensions': 'permessage-deflate; client_max_window_bits',
                'Sec-WebSocket-Version': '13'
            },
            perMessageDeflate: true,
            handshakeTimeout: 30000,
            pingInterval: 30000,
            pongTimeout: 5000
        });

        ws.on('open', () => {
            console.log('✅ Đã kết nối WebSocket xổ số thành công!');
            reconnectAttempts = 0;
        });

        ws.on('message', async (message) => {
            try {
                if (!isLotteryTime()) {
                    console.log('⏰ Đã hết khung giờ xổ số, đóng kết nối...');
                    ws.close();
                    return;
                }

                const text = message.toString();
                console.log('📨 Nhận được tin nhắn:', text.substring(0, 100) + '...');

                const cleanedText = text.replace(/^0\|2!/, '');

                const vietnamTime = new Date().toLocaleString('en-US', { timeZone: 'Asia/Ho_Chi_Minh' });
                const hour = new Date(vietnamTime).getHours();

                let region = '';
                if (hour >= 16 && hour < 17) {
                    region = 'XSMN';
                } else if (hour >= 17 && hour < 18) {
                    region = 'XSMT';
                } else if (hour >= 18 && hour < 19) {
                    region = 'XSMB';
                }

                const stationPattern = /(\d+)\|(\d+)\|([^|]+)\|([^@]+)@([^!]*)/g;
                const results = [];

                let match;
                while ((match = stationPattern.exec(cleanedText)) !== null) {
                    const [, , code, short, province, prizeData] = match;

                    const rawPrizes = prizeData.split('|');
                    const prizes = rawPrizes.map(prize => {
                        if (prize === '') {
                            return [];
                        } else if (prize.includes('-')) {
                            return prize.split('-').filter(p => p !== '');
                        } else {
                            return [prize];
                        }
                    });

                    results.push({
                        region,
                        code,
                        short,
                        province,
                        prizes
                    });
                }

                if (results.length === 0) {
                    return;
                }

                console.log('📋 Dữ liệu xử lý:', results);

                // Gửi dữ liệu về Laravel
                const res = await fetch(LARAVEL_API_URL, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(results),
                });

                if (res.ok) {
                    const data = await res.json();
                    console.log('✅ Laravel trả về:', data);
                } else {
                    console.error('❌ Laravel trả về lỗi:', res.status, res.statusText);
                }
            } catch (error) {
                console.error('❌ Lỗi khi xử lý tin nhắn:', error.message);
            }
        });

        ws.on('ping', () => {
            console.log('🏓 Nhận ping từ server');
        });

        ws.on('pong', () => {
            console.log('🏓 Nhận pong từ server');
        });

        ws.on('error', (error) => {
            console.error('❌ WebSocket error:', error.message);

            if (error.message.includes('400')) {
                console.log('💡 Lỗi 400 - Server có thể chưa mở hoặc đã đóng');
            }
        });

        ws.on('close', (code, reason) => {
            console.log(`🔌 WebSocket đã đóng kết nối - Code: ${code}, Reason: ${reason}`);

            if (reconnectTimer) {
                clearTimeout(reconnectTimer);
            }

            if (!isLotteryTime()) {
                console.log('⏰ Đã hết khung giờ xổ số, sẽ đợi đến khung giờ tiếp theo...');
                const timeToNext = getTimeToNextLottery();
                const hours = Math.floor(timeToNext / (1000 * 60 * 60));
                const minutes = Math.floor((timeToNext % (1000 * 60 * 60)) / (1000 * 60));
                console.log(`⏰ Sẽ thử kết nối lại sau ${hours}h ${minutes}m`);

                reconnectTimer = setTimeout(() => {
                    reconnectAttempts = 0; // Reset counter
                    connectWebSocket();
                }, Math.min(timeToNext, 1800000)); // Tối đa 30 phút
            } else {
                if (reconnectAttempts < maxReconnectAttempts) {
                    reconnectAttempts++;
                    console.log(`⏰ Đang thử kết nối lại sau ${reconnectDelay / 1000} giây... (Lần thử: ${reconnectAttempts}/${maxReconnectAttempts})`);

                    reconnectTimer = setTimeout(() => {
                        connectWebSocket();
                    }, reconnectDelay);
                } else {
                    console.log('❌ Đã thử kết nối lại nhiều lần trong khung giờ xổ số. Đợi khung giờ tiếp theo...');
                    reconnectAttempts = 0;
                    const timeToNext = getTimeToNextLottery();

                    reconnectTimer = setTimeout(() => {
                        connectWebSocket();
                    }, Math.min(timeToNext, 1800000));
                }
            }
        });

    } catch (error) {
        console.error('❌ Lỗi khi tạo WebSocket:', error.message);

        if (reconnectTimer) {
            clearTimeout(reconnectTimer);
        }

        if (isLotteryTime() && reconnectAttempts < maxReconnectAttempts) {
            reconnectAttempts++;
            reconnectTimer = setTimeout(() => {
                connectWebSocket();
            }, reconnectDelay);
        } else {
            const timeToNext = getTimeToNextLottery();
            reconnectTimer = setTimeout(() => {
                reconnectAttempts = 0;
                connectWebSocket();
            }, Math.min(timeToNext, 1800000));
        }
    }
}

connectWebSocket();

process.on('SIGINT', () => {
    console.log('🛑 Đang dừng WebSocket client...');
    if (reconnectTimer) {
        clearTimeout(reconnectTimer);
    }
    if (ws) {
        ws.close();
    }
    process.exit(0);
});

process.on('SIGTERM', () => {
    console.log('🛑 Nhận tín hiệu SIGTERM, đang dừng...');
    if (reconnectTimer) {
        clearTimeout(reconnectTimer);
    }
    if (ws) {
        ws.close();
    }
    process.exit(0);
});

process.on('uncaughtException', (error) => {
    console.error('❌ Uncaught Exception:', error);
    process.exit(1);
});

process.on('unhandledRejection', (reason, promise) => {
    console.error('❌ Unhandled Rejection at:', promise, 'reason:', reason);
    process.exit(1);
});

setInterval(() => {
    const vietnamTime = new Date().toLocaleString('en-US', { timeZone: 'Asia/Ho_Chi_Minh' });
    const now = new Date(vietnamTime);
    const timeStr = now.toLocaleTimeString('vi-VN');

    if (isLotteryTime()) {
        if (ws && ws.readyState === WebSocket.OPEN) {
            console.log(`💓 ${timeStr} - WebSocket đang hoạt động trong khung giờ xổ số`);
        } else {
            console.log(`💔 ${timeStr} - WebSocket không hoạt động trong khung giờ xổ số`);
        }
    } else {
        console.log(`⏰ ${timeStr} - Đang chờ khung giờ xổ số (16:00-19:00)`);
    }
}, 600000);
