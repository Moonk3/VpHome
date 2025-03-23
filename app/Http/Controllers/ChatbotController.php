<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    // public function chat(Request $request)
    // {
    //     $userMessage = $request->input('message');

    //     // Gọi OpenAI API
    //     $response = Http::withHeaders([
    //         'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
    //         'Content-Type' => 'application/json',
    //     ])->post('https://api.openai.com/v1/chat/completions', [
    //         'model' => 'gpt-3.5-turbo', // Hoặc 'gpt-4' nếu bạn có quyền truy cập
    //         'messages' => [
    //             ['role' => 'system', 'content' => 'Bạn là một chatbot thông minh.'],
    //             ['role' => 'user', 'content' => $userMessage]
    //         ]
    //     ]);

    //     return response()->json($response->json());
    // }
    public function chat(Request $request)
{
    $userMessage = $request->input('message');

    if (!$userMessage) {
        return response()->json(['error' => 'Tin nhắn không hợp lệ'], 400);
    }

    try {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'Bạn là một chatbot thông minh.'],
                ['role' => 'user', 'content' => $userMessage]
            ],
            'max_tokens' => 50,
        ]);

        if ($response->failed()) {
            return response()->json([
                'error' => 'Lỗi API OpenAI',
                'status' => $response->status(),
                'details' => $response->json()
            ], 500);
        }

        return response()->json($response->json());

    } catch (\Exception $e) {
        return response()->json(['error' => 'Lỗi hệ thống', 'message' => $e->getMessage()], 500);
    }
}

}
