<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ChatMessage;
use App\Events\CreateMessage;

class ChatMessageController extends Controller
{
    public function store(Request $request): JsonResponse{

        $chatMessage = ChatMessage::create([
            'message' => $request->message,
            'chat_id' => $request->chat_id,
            'user_id' => Auth::user()->id
        ]);

        $chatMessage['user'] = $chatMessage->user;

        event(new CreateMessage($chatMessage,$request->chat_id, Auth::user()));

        return response()->json($chatMessage);
    }
}
