<?php

namespace App\Http\Controllers;

use App\Models\AiPrediction;
use App\Service\AiPredictionService;
use Illuminate\Http\Request;

class AiPredictionController extends Controller
{
    public function __construct(protected AiPredictionService $ai_prediction_service) {}

    public function getAiPredictionForNextDraw(Request $request)
    {
        try {
            $data = $this->ai_prediction_service->getAiPredictionForNextDraw($request);
            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function AiChatBot(Request $request)
    {
        $request->validate(['conversation' => 'required|array']);
        try {
            $massage = $this->ai_prediction_service->AiChatBot($request->conversation ?? null);

            return response()->json($massage, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function AiAnalytic(Request $request)
    {
        if ($request->type === 'lottery') {
            $request->validate([
                'numbers' => 'required|array|min:1',
                'type' => 'required|in:lottery,dream'
            ]);
        } else {
            $request->validate([
                'content' => 'required|string',
                'categories' => 'nullable|array',
                'type' => 'required|in:lottery,dream'
            ]);
        }

        try {
            if ($request->type === 'lottery') {
                $conversation = [
                    [
                        "message" => 'Hãy phân tích những số này thật kĩ: ' . implode(' - ', $request->numbers),
                        "sender" => 'user'
                    ]
                ];
                $type = 'detailed';
            } else {
                $categories = $request->categories ? 'Và loại giấc mơ là: ' . implode(' - ', $request->categories) : '';
                $conversation = [
                    [
                        "message" => 'Hãy phân tích giấc mơ này: ' . $request->content . ' ' . $categories,
                        "sender" => 'user'
                    ]
                ];
                $type = 'dream';
            }

            $message = $this->ai_prediction_service->AiChatBot($conversation, $type);
            return response()->json($message, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
