
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lottery with Spinning Animation</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/3.3.4/vue.global.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* Base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: white;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Lottery Drawing Section */
        .lottery-drawing {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 30px;
            margin-bottom: 30px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .drawing-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .drawing-title {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .drawing-time {
            font-size: 1.2rem;
            opacity: 0.9;
        }

        .drawing-status {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .status-waiting {
            background: rgba(255, 193, 7, 0.3);
            color: #ffc107;
            border: 2px solid #ffc107;
        }

        .status-drawing {
            background: rgba(220, 53, 69, 0.3);
            color: #dc3545;
            border: 2px solid #dc3545;
            animation: pulse 1.5s infinite;
        }

        .status-completed {
            background: rgba(40, 167, 69, 0.3);
            color: #28a745;
            border: 2px solid #28a745;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        /* Prize Drawing Grid */
        .prize-drawing-grid {
            display: grid;
            gap: 20px;
            margin-bottom: 30px;
        }

        .prize-row {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .prize-label {
            min-width: 120px;
            font-weight: bold;
            font-size: 1.1rem;
            text-align: center;
            padding: 10px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        .prize-numbers {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            flex-grow: 1;
        }

        /* Number Ball Styles */
        .number-ball {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .number-ball.special {
            width: 80px;
            height: 80px;
            font-size: 1.5rem;
            background: linear-gradient(45deg, #ff6b6b, #ee5a52);
            box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4);
        }

        .number-ball.normal {
            background: linear-gradient(45deg, #4ecdc4, #44a08d);
            box-shadow: 0 6px 20px rgba(78, 205, 196, 0.3);
        }

        .number-ball.small {
            width: 45px;
            height: 45px;
            font-size: 0.9rem;
            background: linear-gradient(45deg, #a8e6cf, #88d8a3);
        }

        /* Spinning Animation */
        .spinning {
            animation: spin 0.8s linear infinite;
            background: linear-gradient(45deg, #ffd93d, #ff6b6b, #4ecdc4, #45b7d1) !important;
            background-size: 400% 400% !important;
            animation: spin 0.8s linear infinite, gradientShift 2s ease-in-out infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .number-reveal {
            animation: numberReveal 1s ease-out;
        }

        @keyframes numberReveal {
            0% {
                transform: scale(1.5) rotate(180deg);
                opacity: 0;
            }
            50% {
                transform: scale(1.2) rotate(90deg);
                opacity: 0.7;
            }
            100% {
                transform: scale(1) rotate(0deg);
                opacity: 1;
            }
        }

        /* Control Panel */
        .control-panel {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 30px;
        }

        .control-btn {
            padding: 12px 25px;
            border: none;
            border-radius: 25px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .control-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }

        .control-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        /* Connection Status */
        .connection-status {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 20px;
            border-radius: 25px;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .status-connected {
            background: rgba(40, 167, 69, 0.3);
            color: #28a745;
            border: 2px solid #28a745;
        }

        .status-disconnected {
            background: rgba(220, 53, 69, 0.3);
            color: #dc3545;
            border: 2px solid #dc3545;
        }

        .status-indicator {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: currentColor;
            animation: blink 1s infinite;
        }

        @keyframes blink {
            0%, 50% { opacity: 1; }
            51%, 100% { opacity: 0.3; }
        }

        /* Progress Bar */
        .draw-progress {
            width: 100%;
            height: 8px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #4ecdc4, #44a08d);
            border-radius: 4px;
            transition: width 0.5s ease;
        }

        /* Results Display */
        .results-table {
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px;
            overflow: hidden;
            margin-top: 20px;
        }

        .results-table tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .results-table tr:last-child {
            border-bottom: none;
        }

        .results-table td {
            padding: 15px;
            text-align: center;
        }

        .prize-code {
            background: rgba(255, 255, 255, 0.1);
            font-weight: bold;
            min-width: 100px;
        }

        .prize-numbers {
            display: flex;
            gap: 8px;
            justify-content: center;
            flex-wrap: wrap;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .prize-row {
                flex-direction: column;
                text-align: center;
            }

            .prize-label {
                min-width: auto;
            }

            .number-ball {
                width: 50px;
                height: 50px;
                font-size: 1rem;
            }

            .number-ball.special {
                width: 70px;
                height: 70px;
                font-size: 1.3rem;
            }
        }
    </style>
</head>
<body>
    <div id="app">
        <div class="container">
            <div class="lottery-drawing">
                <!-- Header -->
                <div class="drawing-header">
                    <h1 class="drawing-title">@{{ currentSession.title }}</h1>
                    <div class="drawing-time">@{{ formatTime(currentSession.drawTime) }}</div>
                </div>

                <!-- Connection Status -->
                <div class="connection-status" :class="socketConnected ? 'status-connected' : 'status-disconnected'">
                    <div class="status-indicator"></div>
                    @{{ socketConnected ? 'Kết nối thành công' : 'Mất kết nối' }}
                </div>

                <!-- Drawing Status -->
                <div class="text-center">
                    <div class="drawing-status" :class="getStatusClass()">
                        <i :class="getStatusIcon()"></i>
                        @{{ getStatusText() }}
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="draw-progress" v-if="drawingState.isDrawing">
                    <div class="progress-fill" :style="`width: ${drawProgress}%`"></div>
                </div>

                <!-- Control Panel -->
                <div class="control-panel">
                    <button class="control-btn" @click="startDrawing" :disabled="drawingState.isDrawing">
                        <i class="fas fa-play"></i> Bắt đầu quay
                    </button>
                    <button class="control-btn" @click="resetDrawing">
                        <i class="fas fa-refresh"></i> Làm mới
                    </button>
                    <button class="control-btn" @click="toggleAutoMode">
                        <i class="fas fa-robot"></i> @{{ autoMode ? 'Tắt tự động' : 'Bật tự động' }}
                    </button>
                </div>

                <!-- Prize Drawing Grid -->
                <div class="prize-drawing-grid">
                    <div v-for="prize in prizeStructure" :key="prize.code" class="prize-row">
                        <div class="prize-label">@{{ prize.code }}</div>
                        <div class="prize-numbers">
                            <div v-for="(number, index) in getPrizeNumbers(prize)"
                                 :key="`${prize.code}-${index}`"
                                 :class="['number-ball', prize.className, {
                                     'spinning': isNumberSpinning(prize.code, index),
                                     'number-reveal': isNumberRevealed(prize.code, index)
                                 }]">
                                <template v-if="number !== null">@{{ formatNumber(number) }}</template>
                                <template v-else-if="isNumberSpinning(prize.code, index)">
                                    <i class="fas fa-sync-alt"></i>
                                </template>
                                <template v-else>--</template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Results Table (for completed draws) -->
            <div v-if="drawingState.isCompleted" class="results-table">
                <table style="width: 100%;">
                    <tr v-for="prize in prizeStructure" :key="prize.code">
                        <td class="prize-code">@{{ prize.code }}</td>
                        <td>
                            <div class="prize-numbers">
                                <div v-for="number in getPrizeNumbers(prize)"
                                     :key="number"
                                     :class="['number-ball', 'small']">
                                    @{{ formatNumber(number) }}
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <script>
        const { createApp } = Vue;

        createApp({
            data() {
                return {
                    // WebSocket connection
                    socket: null,
                    socketConnected: false,

                    // Drawing state
                    drawingState: {
                        isWaiting: true,
                        isDrawing: false,
                        isCompleted: false,
                        currentPrize: null,
                        currentIndex: 0
                    },

                    // Session info
                    currentSession: {
                        title: 'XSMB - Xổ số miền Bắc',
                        drawTime: new Date(),
                        region: 'XSMB'
                    },

                    // Lottery data
                    lotteryResults: {
                        special_code: [null, null, null, null, null, null],
                        special_prize: [null],
                        first_prize: [null],
                        second_prize: [null, null],
                        third_prize: [null, null, null, null, null, null],
                        fourth_prize: [null, null, null, null],
                        fifth_prize: [null, null, null, null, null, null],
                        sixth_prize: [null, null, null],
                        seventh_prize: [null, null, null, null]
                    },

                    // Animation state
                    spinningNumbers: new Set(),
                    revealedNumbers: new Set(),

                    // Settings
                    autoMode: false,
                    spinDuration: 3000, // 3 seconds per number

                    // Prize structure
                    prizeStructure: [
                        {
                            code: 'Mã ĐB',
                            key: 'special_code',
                            className: 'small',
                            count: 6
                        },
                        {
                            code: 'G.ĐB',
                            key: 'special_prize',
                            className: 'special',
                            count: 1
                        },
                        {
                            code: 'G.1',
                            key: 'first_prize',
                            className: 'normal',
                            count: 1
                        },
                        {
                            code: 'G.2',
                            key: 'second_prize',
                            className: 'normal',
                            count: 2
                        },
                        {
                            code: 'G.3',
                            key: 'third_prize',
                            className: 'normal',
                            count: 6
                        },
                        {
                            code: 'G.4',
                            key: 'fourth_prize',
                            className: 'normal',
                            count: 4
                        },
                        {
                            code: 'G.5',
                            key: 'fifth_prize',
                            className: 'normal',
                            count: 6
                        },
                        {
                            code: 'G.6',
                            key: 'sixth_prize',
                            className: 'normal',
                            count: 3
                        },
                        {
                            code: 'G.7',
                            key: 'seventh_prize',
                            className: 'small',
                            count: 4
                        }
                    ]
                }
            },

            computed: {
                drawProgress() {
                    const totalNumbers = this.getTotalNumberCount();
                    const drawnNumbers = this.getDrawnNumberCount();
                    return totalNumbers > 0 ? (drawnNumbers / totalNumbers) * 100 : 0;
                }
            },

            mounted() {
                this.initializeWebSocket();
                this.checkDrawingSchedule();
            },

            beforeUnmount() {
                if (this.socket) {
                    this.socket.close();
                }
            },

            methods: {
                // WebSocket methods
                initializeWebSocket() {
                    try {
                        // Replace with your actual WebSocket URL
                        this.socket = new WebSocket('ws://localhost:8080/app/yze4ynsdqjxkwnma6alg?protocol=7&client=js&version=8.4.0&flash=false');

                        this.socket.onopen = () => {
                            this.socketConnected = true;
                            console.log('WebSocket connected');
                        };

                        this.socket.onmessage = (event) => {
                            this.handleSocketMessage(JSON.parse(event.data));
                        };

                        this.socket.onclose = () => {
                            this.socketConnected = false;
                            console.log('WebSocket disconnected');
                            // Try to reconnect after 5 seconds
                            setTimeout(() => {
                                this.initializeWebSocket();
                            }, 5000);
                        };

                        this.socket.onerror = (error) => {
                            console.error('WebSocket error:', error);
                        };
                    } catch (error) {
                        console.error('Failed to initialize WebSocket:', error);
                        // Simulate connection for demo
                        this.simulateConnection();
                    }
                },

                simulateConnection() {
                    this.socketConnected = true;
                    console.log('Using simulated connection for demo');
                },

                handleSocketMessage(data) {
                    switch (data.type) {
                        case 'drawing_start':
                            this.handleDrawingStart(data);
                            break;
                        case 'number_draw':
                            this.handleNumberDraw(data);
                            break;
                        case 'drawing_complete':
                            this.handleDrawingComplete(data);
                            break;
                        case 'session_info':
                            this.handleSessionInfo(data);
                            break;
                    }
                },

                // Drawing control methods
                startDrawing() {
                    if (this.drawingState.isDrawing) return;

                    this.drawingState.isWaiting = false;
                    this.drawingState.isDrawing = true;
                    this.drawingState.isCompleted = false;

                    // Send start signal via WebSocket
                    if (this.socket && this.socket.readyState === WebSocket.OPEN) {
                        this.socket.send(JSON.stringify({
                            type: 'start_drawing',
                            region: this.currentSession.region
                        }));
                    } else {
                        // Demo mode - simulate drawing
                        this.simulateDrawing();
                    }
                },

                resetDrawing() {
                    this.drawingState.isWaiting = true;
                    this.drawingState.isDrawing = false;
                    this.drawingState.isCompleted = false;
                    this.drawingState.currentPrize = null;
                    this.drawingState.currentIndex = 0;

                    // Reset all numbers
                    Object.keys(this.lotteryResults).forEach(key => {
                        this.lotteryResults[key] = this.lotteryResults[key].map(() => null);
                    });

                    this.spinningNumbers.clear();
                    this.revealedNumbers.clear();
                },

                toggleAutoMode() {
                    this.autoMode = !this.autoMode;
                },

                // Drawing simulation (for demo)
                simulateDrawing() {
                    const drawSequence = [];

                    // Build drawing sequence
                    this.prizeStructure.forEach(prize => {
                        for (let i = 0; i < prize.count; i++) {
                            drawSequence.push({ prize: prize.key, index: i });
                        }
                    });

                    // Simulate drawing each number
                    let currentStep = 0;
                    const drawNext = () => {
                        if (currentStep >= drawSequence.length) {
                            this.handleDrawingComplete({});
                            return;
                        }

                        const step = drawSequence[currentStep];
                        this.startNumberSpin(step.prize, step.index);

                        setTimeout(() => {
                            const randomNumber = this.generateRandomNumber(step.prize);
                            this.handleNumberDraw({
                                prize: step.prize,
                                index: step.index,
                                number: randomNumber
                            });

                            currentStep++;
                            setTimeout(drawNext, 1000); // 1 second between numbers
                        }, this.spinDuration);
                    };

                    drawNext();
                },

                generateRandomNumber(prizeKey) {
                    if (prizeKey === 'special_code') {
                        return Math.floor(Math.random() * 32) + 1; // 1-32 for date codes
                    }
                    return Math.floor(Math.random() * 100000); // 0-99999 for lottery numbers
                },

                // Animation methods
                startNumberSpin(prizeKey, index) {
                    const key = `${prizeKey}-${index}`;
                    this.spinningNumbers.add(key);
                },

                stopNumberSpin(prizeKey, index, number) {
                    const key = `${prizeKey}-${index}`;
                    this.spinningNumbers.delete(key);
                    this.revealedNumbers.add(key);

                    // Update the result
                    this.lotteryResults[prizeKey][index] = number;

                    // Remove reveal effect after animation
                    setTimeout(() => {
                        this.revealedNumbers.delete(key);
                    }, 1000);
                },

                // Event handlers
                handleDrawingStart(data) {
                    this.drawingState.isWaiting = false;
                    this.drawingState.isDrawing = true;
                    this.drawingState.isCompleted = false;
                },

                handleNumberDraw(data) {
                    this.stopNumberSpin(data.prize, data.index, data.number);
                },

                handleDrawingComplete(data) {
                    this.drawingState.isDrawing = false;
                    this.drawingState.isCompleted = true;
                    this.spinningNumbers.clear();
                },

                handleSessionInfo(data) {
                    this.currentSession = { ...this.currentSession, ...data };
                },

                // Utility methods
                checkDrawingSchedule() {
                    // Check if it's drawing time (example: 18:15 daily)
                    const now = new Date();
                    const drawTime = new Date();
                    drawTime.setHours(18, 15, 0, 0);

                    if (this.autoMode && now >= drawTime && !this.drawingState.isDrawing) {
                        this.startDrawing();
                    }

                    // Check again in 1 minute
                    setTimeout(() => {
                        this.checkDrawingSchedule();
                    }, 60000);
                },

                getPrizeNumbers(prize) {
                    return this.lotteryResults[prize.key] || [];
                },

                isNumberSpinning(prizeCode, index) {
                    const prizeKey = this.prizeStructure.find(p => p.code === prizeCode)?.key;
                    return this.spinningNumbers.has(`${prizeKey}-${index}`);
                },

                isNumberRevealed(prizeCode, index) {
                    const prizeKey = this.prizeStructure.find(p => p.code === prizeCode)?.key;
                    return this.revealedNumbers.has(`${prizeKey}-${index}`);
                },

                formatNumber(number) {
                    if (number === null || number === undefined) return '--';
                    return number.toString().padStart(5, '0');
                },

                formatTime(date) {
                    return new Date(date).toLocaleString('vi-VN');
                },

                getStatusClass() {
                    if (this.drawingState.isWaiting) return 'status-waiting';
                    if (this.drawingState.isDrawing) return 'status-drawing';
                    if (this.drawingState.isCompleted) return 'status-completed';
                },

                getStatusIcon() {
                    if (this.drawingState.isWaiting) return 'fas fa-clock';
                    if (this.drawingState.isDrawing) return 'fas fa-spinner fa-spin';
                    if (this.drawingState.isCompleted) return 'fas fa-check-circle';
                },

                getStatusText() {
                    if (this.drawingState.isWaiting) return 'Chờ quay số';
                    if (this.drawingState.isDrawing) return 'Đang quay số...';
                    if (this.drawingState.isCompleted) return 'Hoàn thành';
                },

                getTotalNumberCount() {
                    return this.prizeStructure.reduce((total, prize) => total + prize.count, 0);
                },

                getDrawnNumberCount() {
                    return Object.values(this.lotteryResults).reduce((total, results) => {
                        return total + results.filter(n => n !== null).length;
                    }, 0);
                }
            }
        }).mount('#app');
    </script>
</body>
</html>
