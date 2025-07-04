export class BaseLotteryDrawingSystem {
    constructor() {
        this.drawingSpeed = 6000;
        this.shuffleSpeed = 100;
        this.date = new Date().toISOString().split('T')[0];
    }

    generateRandomNumber(digits) {
        const min = Math.pow(10, digits - 1);
        const max = Math.pow(10, digits) - 1;
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    delay(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }

    isTimeInDrawingPeriod(time) {
        const now = new Date();
        const currentMinutes = now.getHours() * 60 + now.getMinutes();
        const startMinutes = time.hour * 60 + time.minute;
        const endMinutes = time.endHour * 60 + time.endMinute;
        return currentMinutes >= startMinutes && currentMinutes <= endMinutes;
    }

    playDrawSound() {
        try {
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            const oscillator = audioContext.createOscillator();
            const gainNode = audioContext.createGain();

            oscillator.connect(gainNode);
            gainNode.connect(audioContext.destination);

            oscillator.frequency.setValueAtTime(800, audioContext.currentTime);
            gainNode.gain.setValueAtTime(0.1, audioContext.currentTime);
            gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.1);

            oscillator.start(audioContext.currentTime);
            oscillator.stop(audioContext.currentTime + 0.1);
        } catch (e) {
            // Không phát được âm thanh
        }
    }

    async shuffleAnimation(element, digits, numberSource) {
        element.classList.add('dial', 'shuffling');
        element.innerHTML = '';

        const spans = [];
        for (let i = 0; i < digits; i++) {
            const span = document.createElement('span');
            span.textContent = '0';
            element.appendChild(span);
            spans.push(span);
        }

        while (!numberSource.hasNumber() && this.isDrawing) {
            const randomNumber = this.generateRandomNumber(digits);
            const numberStr = String(randomNumber).padStart(digits, '0');

            for (let j = 0; j < digits; j++) {
                spans[j].textContent = numberStr[j];
            }
            await this.delay(this.shuffleSpeed);
        }

        const finalNumber = numberSource.getNumber();
        const finalStr = String(finalNumber).padStart(digits, '0');

        for (let j = 0; j < digits; j++) {
            spans[j].textContent = finalStr[j];
        }

        element.classList.remove('dial', 'shuffling');
        return finalNumber;
    }

    async resumeDrawing(region) {
        try {
            const currentData = await this.fetchCurrentDrawingData(region);

            if (!currentData || !currentData.numbers) {
                console.log('Không có dữ liệu quay số hiện tại');
                return;
            }

            this.drawnNumbers = Array.isArray(currentData.numbers) ? currentData.numbers : [];
            this.currentNumbers = [...this.drawnNumbers];
            this.date = currentData.date;

            if (this.drawnNumbers.length < this.totalExpectedNumbers) {
                this.isDrawing = true;
                await this.continueDrawing(region, currentData);
            }

        } catch (error) {
            console.error('Lỗi khi resume drawing:', error);
        }
    }

    async continueDrawing(region, currentData) {
        const drawingOrder = this.getDrawingOrder();
        let numberIndex = currentData.numbers.length;

        // this.updateBreadcrumb(region, 'Đang quay...');

        let currentPrizeIndex = 0;
        let currentNumberIndex = 0;
        let tempIndex = 0;

        // Tìm vị trí hiện tại trong quá trình quay
        for (let i = 0; i < drawingOrder.length; i++) {
            const order = drawingOrder[i];
            if (tempIndex + order.count > numberIndex) {
                currentPrizeIndex = i;
                currentNumberIndex = numberIndex - tempIndex;
                break;
            }
            tempIndex += order.count;
        }

        try {
            for (let i = currentPrizeIndex; i < drawingOrder.length; i++) {
                const order = drawingOrder[i];

                if (!this.isDrawing) break;

                this.highlightCurrentPrize(order.prize);

                const startIndex = (i === currentPrizeIndex) ? currentNumberIndex : 0;

                for (let j = startIndex; j < order.count; j++) {
                    if (!this.isDrawing) break;

                    const number = await this.drawSingleNumber(order.prize, j, order.digits, order.special);
                    this.displayNumber(order.prize, j, number);
                }
            }

            // this.updateBreadcrumb(region);

        } catch (error) {
            console.error('Lỗi khi continue drawing:', error);
        }

        this.isDrawing = false;
    }

    // Multi-station specific methods - có thể override trong MultiStationLotterySystem
    async continueStationDrawing(station, currentData) {
        // Default implementation - có thể override
        return this.continueDrawing(station, currentData);
    }

    async resumeAllStationDrawings() {
        // Default implementation cho single station
        return this.resumeDrawing();
    }

    async startAllStationDrawings() {
        // Default implementation cho single station
        return this.startDrawing();
    }

    async startStationDrawing(station) {
        // Default implementation - có thể override
        return this.startDrawing(station);
    }

    getStationState(station) {
        // Default implementation - trả về null cho single station
        return null;
    }

    stopStationDrawing(station) {
        // Default implementation
        if (this.isDrawing !== undefined) {
            this.isDrawing = false;
        }
    }

    stopAllDrawings() {
        // Default implementation
        this.stopStationDrawing();
    }

    updateBreadcrumb(region, status = '') {
        const breadcrumb = document.querySelector('.breadcrumb a');
        if (!breadcrumb) return;

        const regionNames = {
            'XSMB': 'XSMB - Kết quả xổ số miền Bắc',
            'XSMT': 'XSMT - Kết quả xổ số miền Trung',
            'XSMN': 'XSMN - Kết quả xổ số miền Nam'
        };

        const regionName = regionNames[region] || region;
        const dateStr = this.formatDate(this.date);
        breadcrumb.textContent = `${regionName} - ${dateStr}${status ? ' - ' + status : ''}`;
    }

    formatDate(date) {
        return new Date(date).toISOString().split('T')[0];
    }

    // Abstract methods - cần được override bởi các class con
    async fetchCurrentDrawingData(region, station = null) {
        throw new Error('fetchCurrentDrawingData method must be implemented by subclass');
    }

    getDrawingOrder() {
        throw new Error('getDrawingOrder method must be implemented by subclass');
    }

    findPrizeRow(prize, station = null) {
        throw new Error('findPrizeRow method must be implemented by subclass');
    }

    highlightCurrentPrize(prize, station = null) {
        throw new Error('highlightCurrentPrize method must be implemented by subclass');
    }

    async drawSingleNumber(prize, index, digits, stationOrSpecial = false, special = false) {
        throw new Error('drawSingleNumber method must be implemented by subclass');
    }

    displayNumber(prize, index, number, station = null) {
        throw new Error('displayNumber method must be implemented by subclass');
    }

    onSocketData(data) {
        throw new Error('onSocketData method must be implemented by subclass');
    }

    checkDrawingTime() {
        throw new Error('checkDrawingTime method must be implemented by subclass');
    }

    async startDrawing(region = null) {
        throw new Error('startDrawing method must be implemented by subclass');
    }

    updateLotoStats(station = null) {
        throw new Error('updateLotoStats method must be implemented by subclass');
    }
}
