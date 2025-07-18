<?php

namespace App\Http\Controllers;

use App\Models\AiPrediction;
use App\Service\AiPredictionService;
use Illuminate\Http\Request;

class AiPredictionController extends Controller
{
    public function __construct(protected AiPredictionService $ai_prediction_service)
    {

    }

    public function getAiPredictionForNextDraw(Request $request)
    {
        try{
            $data = $this->ai_prediction_service->getAiPredictionForNextDraw($request);
            return response()->json($data, 200);
        }
        catch(\Exception $e){
             return response()->json($e->getMessage(), 500);
        }
    }

    public function AiChatBot(Request $request){
        $request->validate(['conversation' => 'required|array']);
        try{
            $massage = $this->ai_prediction_service->AiChatBot($request->conversation ?? null);

            return response()->json($massage, 200);
        }catch (\Exception $e){
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function AiAnalytic(Request $request){
        $request->validate(['numbers' => 'required|array']);
        try{

            $conversation = [
                [
                    "message" => 'Đã phần tích những số này thật kĩ: ' . implode(' - ', $request->numbers),
                    "sender" => 'user'
                ]
            ];

            $massage = $this->ai_prediction_service->AiChatBot($conversation, 'detailed');

            return response()->json($massage, 200);
        }catch (\Exception $e){
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
