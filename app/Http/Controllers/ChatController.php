<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        return view('chat.index');
    }

    public function sendMessage(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:1000',
            'session_id' => 'required|string'
        ]);

        $userId = auth()->id();
        $sessionId = $validated['session_id'];
        $userMessage = $validated['message'];

        // Lưu tin nhắn của user
        \App\Models\ChatMessage::create([
            'user_id' => $userId,
            'sender' => 'user',
            'message' => $userMessage,
            'session_id' => $sessionId
        ]);

        // Tạo response từ chatbot (Mock response)
        $botResponse = $this->generateBotResponse($userMessage);

        // Lưu tin nhắn bot
        \App\Models\ChatMessage::create([
            'sender' => 'bot',
            'message' => $botResponse,
            'session_id' => $sessionId
        ]);

        return response()->json([
            'success' => true,
            'message' => $botResponse
        ]);
    }

    public function getHistory($sessionId)
    {
        $messages = \App\Models\ChatMessage::where('session_id', $sessionId)
            ->oldest('created_at')
            ->get();

        return response()->json($messages);
    }

    private function generateBotResponse($userMessage)
    {
        return \App\Services\ChatbotService::generateResponse($userMessage, auth()->id());
    }
}
