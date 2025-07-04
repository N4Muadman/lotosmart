import { BaseLotteryDrawingSystem } from './lottery-drawing';

export class XSMBLotterySystem extends BaseLotteryDrawingSystem {
    constructor() {
        super();
        this.isDrawing = false;
        this.numbersQueue = [];
        this.currentNumbers = [];
        this.drawnNumbers = [];
        this.totalExpectedNumbers = 27;
    }

    async init(date) {
        this.date = date;

        if (this.date === new Date().toISOString().slice(0, 10) || this.date === '') {
            await this.checkCurrentDrawingState();
            setInterval(() => this.checkDrawingTime(), 1000);
        }

    }

    async checkCurrentDrawingState() {
        const drawingTime = { hour: 18, minute: 15, endHour: 19, endMinute: 0, region: 'XSMB' };

        if (this.isTimeInDrawingPeriod(drawingTime)) {
            await this.resumeDrawing(drawingTime.region);
        }
    }

    onSocketData(numbers) {
        const newNumbers = numbers.slice(this.currentNumbers.length);
        if (newNumbers.length > 0) {
            this.numbersQueue.push(...newNumbers);
        }
    }

    getDrawingOrder() {
        return [
            { prize: 'G.1', count: 1, digits: 5 },
            { prize: 'G.2', count: 2, digits: 5 },
            { prize: 'G.3', count: 6, digits: 5 },
            { prize: 'G.4', count: 4, digits: 4 },
            { prize: 'G.5', count: 6, digits: 4 },
            { prize: 'G.6', count: 3, digits: 3 },
            { prize: 'G.7', count: 4, digits: 2 },
            { prize: 'G.ĐB', count: 1, digits: 5, special: true }
        ];
    }

    async fetchCurrentDrawingData() {
        try {
            const response = await fetch(`/api/lottery-result?region=XSMB&date=${this.date}`);
            if (!response.ok) return null;

            const data = await response.json();
            return {
                numbers: Object.values(data.numbers || {}),
                date: data.date
            };
        } catch (error) {
            console.error('Error fetching XSMB data:', error);
            return null;
        }
    }

    findPrizeRow(prize) {
        const rows = document.querySelectorAll('.results-table tr');
        for (let row of rows) {
            const prizeCode = row.querySelector('.prize-code');
            if (prizeCode && prizeCode.textContent.trim() === prize) {
                return row;
            }
        }
        return null;
    }

    highlightCurrentPrize(prize) {
        document.querySelectorAll('.current-drawing').forEach(el => {
            el.classList.remove('current-drawing');
        });

        const prizeRow = this.findPrizeRow(prize);
        if (prizeRow) {
            prizeRow.classList.add('current-drawing');
        }
    }

    async drawSingleNumber(prize, index, digits) {
        const prizeRow = this.findPrizeRow(prize);
        const numberElements = prizeRow.querySelectorAll('.number');
        const targetElement = numberElements[index];

        if (!targetElement) return;

        const numberSource = {
            hasNumber: () => this.numbersQueue.length > 0,
            getNumber: () => this.numbersQueue.shift()
        };

        const finalNumber = await this.shuffleAnimation(targetElement, digits, numberSource);
        this.currentNumbers.push(finalNumber);
        return finalNumber;
    }

    checkDrawingTime() {
        const now = new Date();
        if (now.getHours() === 18 && now.getMinutes() === 15 && now.getSeconds() === 0) {
            this.startDrawing();
        }
    }

    async startDrawing() {
        if (this.isDrawing) return;

        this.isDrawing = true;
        this.currentNumbers = [];

        const drawingOrder = this.getDrawingOrder();

        try {
            for (const order of drawingOrder) {
                if (!this.isDrawing) break;
                this.highlightCurrentPrize(order.prize);

                for (let i = 0; i < order.count; i++) {
                    if (!this.isDrawing) break;
                    const number = await this.drawSingleNumber(order.prize, i, order.digits);
                    this.displayNumber(order.prize, i, number);
                }
            }
        } catch (error) {
            console.error('Lỗi khi quay số XSMB:', error);
        }

        this.isDrawing = false;
    }

    displayNumber(prize, index, number) {
        const prizeRow = this.findPrizeRow(prize);
        const numberElements = prizeRow.querySelectorAll('.number');
        const targetElement = numberElements[index];

        if (targetElement) {
            targetElement.textContent = number;
            targetElement.classList.add('drawn');
            this.updateLotoStats();
            this.playDrawSound();
        }
    }

    updateLotoStats() {
        const lotoNumbers = [];
        this.currentNumbers.forEach(number => {
            const lastTwo = String(number).slice(-2);
            lotoNumbers.push(lastTwo);
        });

        for (let i = 0; i <= 9; i++) {
            const resultDiv = document.querySelectorAll('.result-numbers')[i];
            const numbersForDigit = lotoNumbers.map((num, index) => ({ num, index }))
                .filter(({ num }) => num.charAt(0) == i);

            resultDiv.innerHTML = `<div>Đầu ${i}: </div>`;
            numbersForDigit.forEach(({ num, index }) => {
                const ball = document.createElement('div');
                ball.className = `number-ball ${index === 26 ? 'bg-red' : ''}`;
                ball.textContent = num;
                resultDiv.appendChild(ball);
            });
        }
    }
}
