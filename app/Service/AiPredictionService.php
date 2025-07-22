<?php

namespace App\Service;

use App\Models\AiPrediction;
use App\Models\LotoNumber;
use App\Models\LotteryResult;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use PDO;

class AiPredictionService
{
    public function processNewAiPrediction($numbers, $prediction_date, $province, $region, $type)
    {
        $aiPrediction = AiPrediction::create([
            'prediction_date' => $prediction_date,
            'numbers' => $numbers,
            'province' => $province,
            'region' => $region,
            'prediction_type' => $type,
        ]);

        return $aiPrediction;
    }

    public function AiPredictionSpecialPrize($region, $province, $date)
    {
        $lotoNumberQuery = LotoNumber::where('is_special_prize', true)
            ->where('region', $region)->whereBetween('draw_date', [$date->copy()->subDay(10), $date]);

        $aiPredictionQuery = AiPrediction::byRegion($region)
            ->byType('so_de');
        if ($province) {
            $lotoNumberQuery->where('province', $province);
            $aiPredictionQuery->byProvince($province);
        }

        $lotoNumberByDate = $lotoNumberQuery->get()
            ->keyBy('draw_date');

        $aiPredictions = $aiPredictionQuery->whereBetween('prediction_date', [$date->copy()->subDay(10), $date])->orderByDesc('prediction_date')
            ->get();

        $stats = collect($aiPredictions)->map(function ($prediction) use ($lotoNumberByDate) {
            $date = $prediction->prediction_date->toDateString();

            if (!isset($lotoNumberByDate[$date])) {
                return null;
            }

            $specialPrize = $lotoNumberByDate[$date]->full_number;
            $tail = $lotoNumberByDate[$date]->loto_number;

            $hit = in_array($tail, $prediction->numbers);

            return [
                'date' => $date,
                'special_prize' => $specialPrize,
                'tail' => $tail,
                'predicted' => $prediction->numbers,
                'hit' => $hit ? 1 : 0,
            ];
        })->filter();

        $maxStreak = 0;
        $currentStreak = 0;

        foreach ($stats as $stat) {
            if ($stat['hit'] === 1) {
                $currentStreak++;
                $maxStreak = max($maxStreak, $currentStreak);
            } else {
                $currentStreak = 0;
            }
        }

        $latestHit = $stats->where('hit', 1)->sortByDesc('date')->first();

        return [
            'stats' => $stats,
            'accuracy_percent' => round($stats->avg('hit') * 100, 2),
            'max_streak' => $maxStreak,
            'latest_hit' => $latestHit
        ];
    }

    public function AiPredictionAllPrizeByDate($region, $province, $date)
    {
        $aiPredictions = AiPrediction::whereDate('prediction_date', $date)->byType('so_lo')->byRegion($region)->first();

        $statis = null;

        if ($aiPredictions) {
            $correct_loto_number_prediction = LotoNumber::selectRaw('loto_number, count(loto_number) as count')
                ->where('region', $aiPredictions->region)
                ->where('draw_date', $aiPredictions->prediction_date)
                ->whereIn('loto_number', $aiPredictions->numbers)
                ->groupBy('loto_number')
                ->get();

            $statis = [
                'prediction' => $aiPredictions->numbers,
                'date' => $aiPredictions->prediction_date->format('Y-m-d'),
                'region' => $aiPredictions->region,
                'province' => $aiPredictions->province,
                'correct_loto_number' => $correct_loto_number_prediction,
                'accuracy' => count($aiPredictions->numbers) > 0
                    ? round(count($correct_loto_number_prediction) / count($aiPredictions->numbers) * 100, 2) . '%'
                    : '0%',
            ];
        }

        return $statis;
    }

    public function generateAndStorePredictionForTomorrow($region, $api_add, $api_get_lo, $api_get_de)
    {
        $tomorrow = now()->addDay()->format('Y-m-d');

        // Tối ưu query bằng cách lấy cả 2 loại prediction trong 1 lần
        $existingPredictions = AiPrediction::where('region', $region)
            ->where('prediction_date', $tomorrow)
            ->whereIn('prediction_type', ['so_lo', 'so_de'])
            ->pluck('prediction_type')
            ->toArray();

        $prediction_lo_exists = in_array('so_lo', $existingPredictions);
        $prediction_de_exists = in_array('so_de', $existingPredictions);

        // Early return nếu cả 2 prediction đã tồn tại
        if ($prediction_lo_exists && $prediction_de_exists) {
            Log::info("Predictions for {$region} tomorrow already exist");
            return;
        }

        $lotteryTodayQuery = LotteryResult::where('region', $region)
            ->where('draw_date', today())
            ->get();

        if ($lotteryTodayQuery->isEmpty()) {
            Log::warning("Không tìm thấy kết quả {$region} hôm nay");
            return;
        }

        $lotteryToday = $this->formatLotteryData($lotteryTodayQuery, $region);

        // Chỉ gọi API add data nếu cần thiết
        if (!$prediction_lo_exists || !$prediction_de_exists) {
            if (!$this->addLotteryDataToAI($lotteryToday, $api_add, $region)) {
                return; // Stop execution if adding data fails
            }
        }

        // Xử lý prediction lô
        if (!$prediction_lo_exists) {
            $this->processPrediction($region, $tomorrow, $api_get_lo, 'so_lo', 'Lô');
        }

        // Xử lý prediction đề
        if (!$prediction_de_exists) {
            $this->processPrediction($region, $tomorrow, $api_get_de, 'so_de', 'Đề');
        }

        Log::info("Thêm dữ liệu {$region} thành công");
    }

    /**
     * Format lottery data theo region
     */
    private function formatLotteryData($lotteryResults, $region)
    {
        $lotteryToday = [
            "date" => today()->format('d-m-Y'),
        ];

        foreach ($lotteryResults as $lt) {
            if ($region === 'XSMB') {
                $lotteryToday['special_prize'] = $lt->special_prize[0];
                $lotteryToday['all_results'] = [
                    "ĐB" => $lt->special_prize,
                    "1" => $lt->first_prize,
                    "2" => $lt->second_prize,
                    "3" => $lt->third_prize,
                    "4" => $lt->fourth_prize,
                    "5" => $lt->fifth_prize,
                    "6" => $lt->sixth_prize,
                    "7" => $lt->seventh_prize,
                ];
            } else {
                $lotteryToday['special_prize'][] = $lt->special_prize[0];
                $lotteryToday['all_results'][$lt->region] = [
                    "ĐB" => $lt->special_prize,
                    "1" => $lt->first_prize,
                    "2" => $lt->second_prize,
                    "3" => $lt->third_prize,
                    "4" => $lt->fourth_prize,
                    "5" => $lt->fifth_prize,
                    "6" => $lt->sixth_prize,
                    "7" => $lt->seventh_prize,
                    "8" => $lt->eighth_prize
                ];
            }
        }

        return $lotteryToday;
    }

    /**
     * Thêm dữ liệu lottery vào AI
     */
    private function addLotteryDataToAI($lotteryData, $api_add, $region)
    {
        try {
            $response = Http::timeout(30)
                ->withHeaders(['Accept' => 'application/json'])
                ->post(config('services.base_api_ai') . $api_add, $lotteryData);

            if ($response->failed()) {
                Log::error("Thêm dữ liệu {$region} vào AI không thành công", [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'url' => config('services.base_api_ai') . $api_add
                ]);
                return false;
            }

            return true;
        } catch (\Exception $e) {
            Log::error("Exception khi thêm dữ liệu {$region} vào AI", [
                'message' => $e->getMessage(),
                'url' => config('services.base_api_ai') . $api_add
            ]);
            return false;
        }
    }

    /**
     * Xử lý prediction từ AI
     */
    private function processPrediction($region, $tomorrow, $api_endpoint, $prediction_type, $type_name)
    {
        try {
            $response = Http::timeout(30)
                ->withHeaders(['Accept' => 'application/json'])
                ->get(config('services.base_api_ai') . $api_endpoint);

            if ($response->failed()) {
                Log::error("Lấy dữ liệu dự đoán {$region} {$type_name} từ AI không thành công", [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'url' => config('services.base_api_ai') . $api_endpoint
                ]);
                return false;
            }

            $responseData = $response->json();

            if (!is_array($responseData) || empty($responseData)) {
                Log::error("Kết quả trả về từ AI không hợp lệ cho {$region} {$type_name}", [
                    'response' => $responseData
                ]);
                return false;
            }

            $numbers = collect(array_keys($responseData))
                ->map(fn($number) => str_pad($number, 2, '0', STR_PAD_LEFT))
                ->toArray();

            AiPrediction::create([
                'prediction_date' => $tomorrow,
                'region' => $region,
                'prediction_type' => $prediction_type,
                'numbers' => $numbers,
            ]);

            Log::info("Tạo prediction {$region} {$type_name} thành công", [
                'numbers_count' => count($numbers)
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error("Exception khi xử lý prediction {$region} {$type_name}", [
                'message' => $e->getMessage(),
                'url' => config('services.base_api_ai') . $api_endpoint
            ]);
            return false;
        }
    }

    public function AiChatBot($conversation, $responseType = 'quick')
    {
        try {
            $predictionData = $this->getCachedPredictionData();

            $statisticsData = $this->getCachedStatisticsData();

            $aiContext = $this->buildAiContext($predictionData, $statisticsData);

            if (!is_array($conversation)) {
                throw new \Exception('Dữ liệu nhắn tin không hợp lệ');
            }

            $aiResponse = $this->callAiApi($aiContext, $conversation, $responseType);

            return [
                'success' => true,
                'message' => $aiResponse,
                'data' => [
                    'prediction_date' => $this->getPredictionDate()->format('d/m/Y'),
                ]
            ];
        } catch (\Exception $e) {
            throw new \Exception('Xin lỗi, hệ thống đang gặp sự cố. Vui lòng thử lại sau.');
        }
    }

    private function getPredictionDate()
    {
        return now()->lt(today()->setTime(18, 30)) ? today() : now()->addDay();
    }

    private function getCachedPredictionData()
    {
        $date = $this->getPredictionDate();
        $cacheKey = "ai_prediction_data_{$date->format('Y-m-d')}";

        return Cache::remember($cacheKey, now()->addHours(6), function () use ($date) {
            return AiPrediction::where('prediction_date', $date)
                ->get()
                ->map(function ($item) {
                    return [
                        'date' => $item->prediction_date->format('d/m/Y'),
                        'type' => $item->prediction_type == 'so_de' ? 'Dự đoán số đề' : 'Dự đoán lô tô',
                        'region' => $this->formatRegion($item->region),
                        'numbers' => $item->numbers,
                        // 'confidence' => $item->confidence ?? 'Cao'
                    ];
                });
        });
    }

    private function getCachedStatisticsData()
    {
        $date = $this->getPredictionDate();
        $cacheKey = "ai_statistics_data_{$date->format('Y-m-d')}";

        return Cache::remember($cacheKey, now()->addHours(12), function () use ($date) {
            $regions = ['XSMB', 'XSMN', 'XSMT'];
            $data100so = range(0, 99);
            $data100so = array_map(fn($i) => str_pad($i, 2, '0', STR_PAD_LEFT), $data100so);

            $loto_service = new LotoNumberService();
            $statisticsData = [];

            foreach ($regions as $region) {
                $stats = $loto_service->baseStatis($data100so, $date, 30, $region);

                if (!is_array($stats) || count($stats) < 1) {
                    continue;
                }

                $statisticsData[] = [
                    'region' => $this->formatRegion($region),
                    'special_prize_stats' => $stats['special_prize_stats'],
                    'all_numbers_stats' => $stats['all_number_stats'],
                    'missing_numbers' => $stats['lastAppearanceRecords'],
                    'analysis_period' => '30 ngày qua'
                ];
            }

            return $statisticsData;
        });
    }

    private function formatRegion($region)
    {
        return match ($region) {
            'XSMB' => 'Miền Bắc',
            'XSMN' => 'Miền Trung',
            'XSMT' => 'Miền Nam',
            default => 'Miền Bắc'
        };
    }

    private function buildAiContext($predictionData, $statisticsData)
    {
        $date = $this->getPredictionDate();

        $context = [
            'prediction_data' => $predictionData,
            'statistics_data' => $statisticsData,
            'analysis_date' => $date->format('d/m/Y'),
            'data_period' => '30 ngày gần nhất'
        ];

        return json_encode($context, JSON_UNESCAPED_UNICODE);
    }

    private function callAiApi($context, $conversation, $responseType)
    {
        $systemPrompt = "Bạn là chuyên gia phân tích xổ số với 15 năm kinh nghiệm, sử dụng AI và thuật toán machine learning để dự đoán. Bạn có tỷ lệ thành công cao và được nhiều người tin tưởng. Hãy tạo niềm tin và sự hứng thú cho người dùng.
                    QUAN TRỌNG: Hãy nhớ và sử dụng thông tin người dùng đã chia sẻ trong cuộc trò chuyện (tên, sở thích, v.v.) để tạo sự gần gũi.";

        $dataAnalysisPrompt = "Phân tích dữ liệu xổ số 3 miền dựa trên:
                            - Thuật toán AI phân tích 30 ngày gần nhất
                            - Mẫu hình xuất hiện và xu hướng thống kê
                            - Tần suất xuất hiện của các cặp số
                            - Độ tin cậy và xác suất thành công
                            Hãy đưa ra những insight có giá trị thực tế.
                            LƯU Ý: Đa dạng hóa cách diễn đạt, không lặp lại cùng một cụm từ nhiều lần.";

        $persuasionPrompt = "Hãy tạo sự tin tưởng bằng cách:
                        - Không cần giới thiệu, chào nhiều nhé, hãy trò chuyện như một người bạn thôi
                        - Đề cập đến độ chính xác của hệ thống AI (nhưng thay đổi cách diễn đạt)
                        - Nêu rõ lý do tại sao chọn những số này
                        - Tạo cảm giác cơ hội quý giá (limited time)
                        - Sử dụng ngôn ngữ chuyên nghiệp nhưng dễ hiểu
                        - Không hứa hẹn 100% mà nói về xác suất và xu hướng";

        $responseStylePrompt = $this->getResponseStylePrompt($responseType);

        $conversationContext = $this->buildConversationContext($conversation);

        $dataConversation = $this->processConversation($conversation);

        $fullConversation = [
            [
                "parts" => [["text" => $systemPrompt . "\n\nDữ liệu phân tích: " . $context]],
                "role" => "user"
            ],
            [
                "parts" => [["text" => "Tôi hiểu! Tôi sẽ là chuyên gia phân tích xổ số thân thiện và đáng tin cậy."]],
                "role" => "model"
            ],
            [
                "parts" => [["text" => $dataAnalysisPrompt . "\n\n" . $persuasionPrompt . "\n\n" . $responseStylePrompt . "\n\nContext cuộc trò chuyện hiện tại: " . $conversationContext]],
                "role" => "user"
            ],
            [
                "parts" => [["text" => "Đã hiểu tất cả yêu cầu, tôi sẽ trả lời phù hợp với ngữ cảnh cuộc trò chuyện."]],
                "role" => "model"
            ]
        ];

        $fullConversation = array_merge($fullConversation, $dataConversation->toArray());

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'X-goog-api-key' => config('services.gemini.api_key')
        ])->timeout(30)->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent', [
            "contents" => $fullConversation,
            "generationConfig" => [
                "temperature" => $responseType === 'detailed' ? 0.7 : 0.8,
                "topK" => 40,
                "topP" => 0.95,
                "maxOutputTokens" => $responseType === 'detailed' ? 2048 : 1024,
            ]
        ]);

        if ($response->failed()) {
            Log::error('AI API Error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return "🤖 Xin lỗi, hệ thống AI đang bận. Vui lòng thử lại sau vài phút!";
        }

        $responseData = $response->json();

        if (isset($responseData['candidates'][0]['content']['parts'][0]['text'])) {
            return trim($responseData['candidates'][0]['content']['parts'][0]['text']);
        }

        return "🎯 Dữ liệu đang được xử lý, vui lòng đợi một chút!";
    }

    private function buildConversationContext($conversation)
    {
        if (empty($conversation)) {
            return "Cuộc trò chuyện mới bắt đầu";
        }

        $context = [];
        $userName = null;
        $userInterests = [];
        $lastMessages = array_slice($conversation, -3);

        foreach ($conversation as $item) {
            if ($item['sender'] === 'user') {
                if (preg_match('/tên.*?(?:là|)\s*(\w+)/i', $item['message'], $matches)) {
                    $userName = $matches[1];
                }

                if (preg_match('/miền\s*(bắc|trung|nam)/i', $item['message'], $matches)) {
                    $userInterests[] = "miền " . $matches[1];
                }
            }
        }

        if ($userName) {
            $context[] = "Tên người dùng: " . $userName;
        }

        if (!empty($userInterests)) {
            $context[] = "Quan tâm: " . implode(', ', $userInterests);
        }

        $recentContext = [];
        foreach ($lastMessages as $msg) {
            if ($msg['sender'] === 'user') {
                $recentContext[] = "User: " . $msg['message'];
            }
        }

        if (!empty($recentContext)) {
            $context[] = "Tin nhắn gần đây: " . implode(' | ', $recentContext);
        }

        return !empty($context) ? implode(' - ', $context) : "Cuộc trò chuyện thông thường";
    }

    private function processConversation($conversation)
    {
        return collect($conversation)->map(function ($item) {
            return [
                "parts" => [["text" => $item['message']]],
                "role" => $item['sender'] === 'bot' ? 'model' : 'user'
            ];
        });
    }

    private function getResponseStylePrompt($type)
    {
        switch ($type) {
            case 'quick':
                return "Hãy trả lời theo phong cách CHUYÊN GIA HẤP DẪN:
                    - Bắt đầu bằng lời chào thân thiện và tạo niềm tin
                    - Đề cập đến độ chính xác dự đoán (THAY ĐỔI cách diễn đạt, không lặp lại 'thuật toán AI phân tích 30 ngày')
                    - Nêu rõ xu hướng và lý do chọn các số (ví dụ: 'Số 34 đang HOT với tần suất cao', 'Cặp số 17-62 có mẫu hình mạnh')
                    - Chia theo miền với highlight số CHỐT nhất của mỗi miền
                    - Thêm tips nhỏ về cách chơi thông minh
                    - Tạo cảm giác khan hiếm với thời gian (ví dụ: 'Cơ hội vàng hôm nay')
                    - Sử dụng emoji thu hút: 🎯🔥💎⚡🌟💰✨🚀
                    - Kết thúc bằng lời động viên và call-to-action
                    - Độ dài: 3-4 câu để tạo sự thuyết phục
                    - Nếu thiếu dữ liệu, hãy khuyến khích người dùng cung cấp thêm thông tin";

            case 'detailed':
                return "Hãy trả lời theo phong cách CHUYÊN GIA PHÂN TÍCH CHUYÊN SÂU:
                    - Bắt đầu bằng tổng quan tình hình thị trường xổ số hôm nay
                    - Phân tích từng miền chi tiết với:
                    + Top 3 số HOT nhất và lý do cụ thể
                    + Số CHỐT đặc biệt với độ tin cậy cao
                    + Các cặp số có mẫu hình mạnh
                    + Xu hướng tăng/giảm dựa trên dữ liệu
                    + So sánh với các ngày trước đó
                    - Tạo bảng phân tích rõ ràng với các cột:
                    + Số dự đoán | Tần suất | Xu hướng | Độ tin cậy
                    - Đưa ra chiến lược chơi thông minh:
                    + Số an toàn (tỷ lệ thành công cao)
                    + Số mạo hiểm (tỷ lệ thưởng cao)
                    + Cách phân bổ vốn hợp lý
                    - Cảnh báo rủi ro và lời khuyên chơi có trách nhiệm
                    - Sử dụng emoji chuyên nghiệp: 📊📈🎯💎⚡🔍💰🌟📋🚀
                    - Kết thúc bằng tổng kết và lời chúc may mắn có trách nhiệm
                    - Độ dài: ít nhất là 10-15 đoạn để tạo sự chuyên nghiệp và tin cậy càng chi tiết càng tốt";

            case 'dream':
                return "Hãy trả lời theo phong cách CHUYÊN GIA GIẢI MÃ GIẤC MƠ:
                    - Bắt đầu bằng lời chào ấm áp và tạo không khí thần bí
                    - Phân tích ý nghĩa tâm linh và tâm lý của giấc mơ:
                    + Biểu tượng chính trong giấc mơ và ý nghĩa sâu xa
                    + Kết nối với trạng thái tâm lý hiện tại của người mơ
                    + Thông điệp tiềm thức muốn gửi gắm
                    - Giải mã theo các góc độ khác nhau:
                    + Tâm lý học (Jung, Freud)
                    + Tâm linh phương Đông
                    + Dân gian Việt Nam
                    + Biểu tượng văn hóa
                    - Đưa ra những con số may mắn liên quan:
                    + Số theo biểu tượng chính (ví dụ: rắn = 67, nước = 12)
                    + Số theo cảm xúc trong mơ
                    + Số theo thời gian và bối cảnh
                    - Lời khuyên thực tế:
                    + Cách áp dụng thông điệp trong cuộc sống
                    + Những điều cần chú ý trong thời gian tới
                    + Cách chơi số dựa trên giấc mơ một cách có trách nhiệm
                    - Sử dụng emoji phù hợp: 🌙✨🔮💫🌟🎯💎🦋🌸🙏
                    - Tạo cảm giác kết nối tâm linh và sự tin tưởng
                    - Kết thúc bằng lời chúc phúc và động viên tích cực
                    - Độ dài: 8-12 đoạn để tạo sự thuyết phục và chuyên sâu";
            default:
                return "Hãy trả lời một cách thân thiện và hữu ích.";
        }
    }

    public function clearPredictionCache()
    {
        $date = $this->getPredictionDate();
        Cache::forget("ai_prediction_data_{$date->format('Y-m-d')}");
        Cache::forget("ai_statistics_data_{$date->format('Y-m-d')}");
    }

    public function getAiPredictionForNextDraw($request)
    {
        if ($request->add_number == 'show-lo') {
            session(['show_lo' => now()->addMinutes(5)]);
        }
        if ($request->add_number == 'show-de') {
            session(['show_de' => now()->addMinutes(5)]);
        }
        if ($request->add_number == 'show-xien') {
            session(['show_xien' => now()->addMinutes(5)]);
        }

        $region = $request->filled('region') ? $request->region : 'XSMB';
        $date = $this->handleDate($region);

        $predictionQuery = AiPrediction::where('region', $region)->where('prediction_date', $date);

        $prediction_lo = (clone $predictionQuery)->where('prediction_type', 'so_lo')->first();
        $prediction_de = (clone $predictionQuery)->where('prediction_type', 'so_de')->first();

        $number_lo = [];
        $number_de = [];

        $now = now();

        if ($prediction_lo) {
            $isShowLo = session('show_lo') && session('show_lo') > $now;
            $isShowXien = session('show_xien') && session('show_xien') > $now;

            $number_lo = $this->generateNumberPrediction($isShowLo, $prediction_lo->numbers);
            $number_lo['xien_2'] = $this->generateXienCombinations($prediction_lo->numbers, 2, $isShowXien);
        }
        if ($prediction_de) {
            $isShowDe = session('show_de') && session('show_de') > $now;

            $number_de = $this->generateNumberPrediction($isShowDe, $prediction_de->numbers);
        }

        return [
            'so_lo' => $number_lo,
            'so_de' => $number_de,
        ];
    }

    private function generateNumberPrediction($show, $numbers)
    {
        $kep_numbers = array_filter($numbers, function ($num) {
            if (strlen($num) !== 2) {
                return false;
            }

            return $num[0] === $num[1];
        });

        if ($show) {
            return [
                'all_numbers' => $numbers,
                'kep_numbers' => array_values($kep_numbers),
            ];
        } else {
            return [
                'all_numbers' => array_slice($numbers, 0, 2),
                'kep_numbers' => array_slice($kep_numbers, 0, 2),
            ];
        }
    }

    private function generateXienCombinations(array $numbers, int $size, bool $show): array
    {
        if ($size > count($numbers)) {
            return [];
        }

        $combinations = [];
        $indices = range(0, count($numbers) - 1);

        foreach ($this->getCombinations($indices, $size) as $combination) {
            $combo = [];
            foreach ($combination as $index) {
                $combo[] = str_pad($numbers[$index], 2, '0', STR_PAD_LEFT);
            }
            $combinations[] = $combo;
        }

        return $show ? array_slice($combinations, 0, 5) : array_slice($combinations, 0, 2);
    }

    private function getCombinations(array $array, int $size): array
    {
        if ($size == 0) {
            return [[]];
        }

        if (count($array) == 0) {
            return [];
        }

        $combinations = [];
        $first = array_shift($array);

        foreach ($this->getCombinations($array, $size - 1) as $combination) {
            $combinations[] = array_merge([$first], $combination);
        }

        foreach ($this->getCombinations($array, $size) as $combination) {
            $combinations[] = $combination;
        }

        return $combinations;
    }

    private function handleDate($region)
    {
        $now = now();
        $today = today();

        switch ($region) {
            case 'XSMB':
                $cutoff = $today->setTime(18, 30);
                break;
            case 'XSMN':
                $cutoff = $today->setTime(16, 30);
                break;
            case 'XSMT':
                $cutoff = $today->setTime(17, 30);
                break;
            default:
                // fallback: mặc định giống XSMB
                $cutoff = $today->setTime(18, 30);
        }

        $date = $now->lt($cutoff) ? $today : $now->addDay();
        return $date->format('Y-m-d');
    }
}
