import { BaseLotteryDrawingSystem } from './lottery-drawing';

export class MultiStationLotterySystem extends BaseLotteryDrawingSystem {
    constructor(type) {
        super();
        this.type = type;
        this.stations = new Map();
        this.isDrawing = new Map();
        this.drawnNumbers = new Map();
        this.currentNumbers = new Map();
        this.numbersQueue = new Map();
        this.totalExpectedNumbers = 18;
        this.allStationData = new Map();
        this.provinceIndexMap = new Map();
    }

    async init(date, stations = []) {
        this.date = date;


        this.stations = new Map(stations.map(province => [province, province]));
        stations.forEach((province, index) => this.provinceIndexMap.set(province, index));
        if (this.date === new Date().toISOString().slice(0, 10) || this.date === '') {
            await this.checkCurrentDrawingState();
            setInterval(() => {
                this.checkDrawingTime();
            }, 1000);
        }
    }

    async checkCurrentDrawingState() {
        const drawingTime = this.getDrawingTime();
        if (this.isTimeInDrawingPeriod(drawingTime)) {
            const allData = await this.fetchCurrentDrawingData();
            if (allData) {
                this.allStationData = allData;
                await Promise.all([...this.stations.keys()].map(province => this.resumeStationDrawing(province)))
            }
        }
    }

    getDrawingTime() {
        if (this.type === 'XSMN') {
            return { hour: 16, minute: 15, endHour: 17, endMinute: 0, region: this.type };
        } else if (this.type === 'XSMT') {
            return { hour: 17, minute: 15, endHour: 18, endMinute: 0, region: this.type };
        }
    }

    onSocketData(data) {
        for (const [province, numbers] of Object.entries(data)) {
            const current = this.currentNumbers.get(province) || [];
            const currentSet = new Set(current);

            const newNumbers = numbers.filter(n => !currentSet.has(n));

            if (newNumbers.length > 0) {
                const queue = this.numbersQueue.get(province) || [];
                this.numbersQueue.set(province, [...queue, ...newNumbers]);
            }
        }
    }

    getDrawingOrder() {
        return [
            { prize: '8', count: 1, digits: 2 },
            { prize: '7', count: 1, digits: 3 },
            { prize: '6', count: 3, digits: 4 },
            { prize: '5', count: 1, digits: 4 },
            { prize: '4', count: 7, digits: 5 },
            { prize: '3', count: 2, digits: 5 },
            { prize: '2', count: 1, digits: 5 },
            { prize: '1', count: 1, digits: 5 },
            { prize: 'ĐB', count: 1, digits: 6, special: true }
        ];
    }

    async fetchCurrentDrawingData() {
        try {
            const response = await fetch(`/api/lottery-result?region=${this.type}&date=${this.date}`);
            if (!response.ok) return null;

            const data = await response.json();
            const stationData = data.results.reduce((acc, result) => {
                acc.set(result.lottery.province, {
                    numbers: result.numbers,
                    loto: result.loto,
                    date: data.date
                });
                return acc;
            }, new Map());
            return stationData;
        } catch (error) {
            console.error(`Error fetching ${this.type} data:`, error);
            return null;
        }
    }

    findPrizeRow(prize, province) {
        const table = document.querySelector('.results-table');
        if (!table) return null;

        const rows = table.querySelectorAll('tr');

        for (let row of rows) {
            const prizeCode = row.querySelector('.prize-code');

            if (prizeCode && prizeCode.textContent.trim() === prize) {
                const index = this.provinceIndexMap.get(province);

                const cells = row.querySelectorAll('.prize-numbers');
                if (index >= 0 && index < cells.length) {
                    return cells[index];
                }
            }
        }
        return null;
    }

    highlightCurrentPrize(prize, province) {
        const table = document.querySelector('.results-table');
        if (!table) return;

        const rows = table.querySelectorAll('tr');
        for (let row of rows) {
            const prizeCode = row.querySelector('.prize-code');
            if (prizeCode && prizeCode.textContent.trim() === prize) {
                const index = this.provinceIndexMap.get(province);
                const cells = row.querySelectorAll('.prize-numbers');
                if (index >= 0 && index < cells.length) {
                    cells.forEach(cell => cell.classList.remove('current-drawing'));
                    cells[index].classList.add('current-drawing');
                    break;
                }
            }
        }
    }

    async drawSingleNumber(prize, index, digits, province, special = false) {
        const prizeRow = this.findPrizeRow(prize, province);

        const numberElements = prizeRow.querySelectorAll('.number');
        const targetElement = numberElements[index];

        if (!targetElement) return;

        const numberSource = {
            hasNumber: () => this.numbersQueue.get(province)?.length > 0 || false,
            getNumber: () => this.numbersQueue.get(province)?.shift() || this.generateRandomNumber(digits)
        };

        const finalNumber = await this.shuffleAnimation(targetElement, digits, numberSource);

        const current = this.currentNumbers.get(province) || [];
        this.currentNumbers.set(province, [...current, finalNumber]);
        return finalNumber;
    }

    displayNumber(prize, index, number, province) {
        const prizeRow = this.findPrizeRow(prize, province);
        if (prizeRow) {
            const numberElements = prizeRow.querySelectorAll('.number');
            const targetElement = numberElements[index];
            if (targetElement) {
                targetElement.textContent = number;
                targetElement.classList.add('drawn');
                this.updateLotoStats(province);
                this.playDrawSound();
            }
        }
    }

    updateLotoStats(province) {
        const lotoNumbers = (this.currentNumbers.get(province) || []).map(number => String(number).slice(-2));

        const resultDiv = document.querySelector(`.lottery-result-statis[data-province="${province}"]`);
        if (!resultDiv) return;

        const resultNumbers = resultDiv.querySelectorAll('.result-numbers');
        resultNumbers.forEach((div, i) => {
            const numbersForDigit = lotoNumbers.map((num, index) => ({ num, index }))
                .filter(({ num }) => num.charAt(0) === String(i));

            div.innerHTML = `<div>Đầu ${i}: </div>`;
            numbersForDigit.forEach(({ num, index }) => {
                const ball = document.createElement('div');
                ball.className = `number-ball p-2 bg-gray-100 rounded ${index === 17 ? 'bg-red text-white' : ''}`;
                ball.textContent = num;
                div.appendChild(ball);
            });
        });
    }

    checkDrawingTime() {
        const now = new Date();
        const drawHour = this.getDrawingTime();
        if (now.getHours() === drawHour.hour && now.getMinutes() === drawHour.minute && now.getSeconds() === 0) {
            this.startAllStationDrawings();
        }
    }

    async startAllStationDrawings() {
        await Promise.all([...this.stations.keys()].map(province => this.startStationDrawing(province)));
    }

    async startStationDrawing(province) {
        if (this.isDrawing.get(province)) return;

        this.isDrawing.set(province, true);
        this.currentNumbers.set(province, []);

        const drawingOrder = this.getDrawingOrder();

        try {
            for (const order of drawingOrder) {
                if (!this.isDrawing.get(province)) break;
                this.highlightCurrentPrize(order.prize, province);

                for (let i = 0; i < order.count; i++) {
                    if (!this.isDrawing.get(province)) break;
                    const number = await this.drawSingleNumber(order.prize, i, order.digits, province, order.special);
                    this.displayNumber(order.prize, i, number, province);
                }
            }
        } catch (error) {
            console.error(`Error starting drawing for ${province}:`, error);
        }

        this.isDrawing.set(province, false);
    }

    async resumeStationDrawing(province) {
        const currentData = this.allStationData.get(province);

        if (!currentData || !currentData.numbers) {
            console.log(`No data for province ${province}`);
            return;
        }

        this.drawnNumbers.set(province, currentData.numbers);
        this.currentNumbers.set(province, [...currentData.numbers]);
        this.date = currentData.date;

        if (this.drawnNumbers.get(province).length < this.totalExpectedNumbers) {
            this.isDrawing.set(province, true);
            await this.continueStationDrawing(province, currentData);
        }
    }

    async continueStationDrawing(province, currentData) {
        const drawingOrder = this.getDrawingOrder();
        let numberIndex = currentData.numbers.length;

        let currentPrizeIndex = 0;
        let currentNumberIndex = 0;
        let tempIndex = 0;

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
                if (!this.isDrawing.get(province)) break;

                this.highlightCurrentPrize(order.prize, province);

                const startIndex = (i === currentPrizeIndex) ? currentNumberIndex : 0;
                for (let j = startIndex; j < order.count; j++) {
                    if (!this.isDrawing.get(province)) break;
                    const number = await this.drawSingleNumber(order.prize, j, order.digits, province, order.special);
                    this.displayNumber(order.prize, j, number, province);
                }
            }
        } catch (error) {
            console.error(`Error continuing drawing for ${province}:`, error);
        }

        this.isDrawing.set(province, false);
    }

    getStationState(province) {
        return {
            isDrawing: this.isDrawing.get(province) || false,
            numbers: this.currentNumbers.get(province) || [],
            status: this.stations.get(province) || 'pending'
        };
    }

    stopStationDrawing(province) {
        if (this.isDrawing.get(province) !== undefined) {
            this.isDrawing.set(province, false);
        }
    }

    stopAllDrawings() {
        for (const [province] of this.stations) {
            this.stopStationDrawing(province);
        }
    }

    updateBreadcrumb(province, status = '') {
        const breadcrumb = document.querySelector(`.breadcrumb[data-province="${province}"]`);
        if (!breadcrumb) return;

        const regionNames = {
            'XSMN': 'XSMN - Kết quả xổ số miền Nam',
            'XSMT': 'XSMT - Kết quả xổ số miền Trung'
        };
        const regionName = regionNames[this.type] || this.type;
        const dateStr = this.formatDate(this.date);
        breadcrumb.textContent = `${regionName} - ${province} - ${dateStr}${status ? ' - ' + status : ''}`;
    }
}
