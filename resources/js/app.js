import './bootstrap';
import { createApp } from 'vue';
import { XSMBLotterySystem } from './XSMBLotterySystem';
import { MultiStationLotterySystem } from './MultiStationLotterySystem';
import Chart from 'chart.js/auto';
import * as d3 from 'd3';
import '@fortawesome/fontawesome-free/css/all.min.css';

window.Chart = Chart;
window.d3 = d3;
window.createVueApp = createApp;
window.createLotterySystem = function(type, stations = []) {
    switch (type) {
        case 'XSMB':
            return new XSMBLotterySystem();
        case 'XSMT':
            return new MultiStationLotterySystem('XSMT');
        case 'XSMN':
            return new MultiStationLotterySystem('XSMN');
        default:
            throw new Error(`Unsupported lottery type: ${type}`);
    }
};
