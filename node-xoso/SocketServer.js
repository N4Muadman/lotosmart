const WebSocket = require('ws');
const fetch = require('node-fetch');

const ws = new WebSocket('wss://livexs.xoso.com.vn/', {
    headers: {
        'Origin': 'https://xoso.com.vn',
        'User-Agent': 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36',
        'Cache-Control': 'no-cache',
        'Pragma': 'no-cache',
    },
    perMessageDeflate: true
});

ws.on('open', () => {
    console.log('✅ Đã kết nối WebSocket xổ số!');
});
ws.on('message', async (message) => {

    const now = new Date();
    if (now.getHours() < 16 || now.getHours() >= 19) return;

    const text = message.toString();

    const cleanedText = text.replace(/^0\|2!/, '');

    let region = '';
    if (now.getHours() >= 16 && now.getHours() < 17) {
        region = 'XSMN';
    } else if (now.getHours() >= 17 && now.getHours() < 18) {
        region = 'XSMT';
    } else if (now.getHours() >= 18 && now.getHours() < 19) {
        region = 'XSMB';
    }

    const parts = cleanedText.split('!').filter(part => part.trim() !== '');

    const stationPattern = /(\d+)\|(\d+)\|([^|]+)\|([^@]+)@([^!]*)/g;
    const results = [];

    let match;
    while ((match = stationPattern.exec(cleanedText)) !== null) {
        const [, , code, short, province, prizeData] = match;

        const rawPrizes = prizeData.split('|').filter(p => p !== '');
        const prizes = rawPrizes.map(prize => prize.includes('-') ? prize.split('-') : [prize]);

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

    try {
        const res = await fetch('http://localhost:8000/api/new-lottery-results', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json'
             },
            body: JSON.stringify(results)
        });

        const data = await res.json();
        console.log('Laravel trả về:', data);
    } catch (error) {
        console.error('Lỗi khi gửi về Laravel:', error.message);
    }
});
