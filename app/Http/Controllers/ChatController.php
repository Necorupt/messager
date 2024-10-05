<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\ChatUser;
use App\Models\User;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(Auth::user()->chats);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->only(['name', 'description']);

        $chat = Chat::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'owner_id' => Auth::id()
        ]);

        ChatUser::create([
            'user_id' => $chat->owner_id,
            'role_id' => 1,
            'chat_id' => $chat->id
        ]);


        return response()->json($chat);
    }

    public function show($id): JsonResponse
    {
        return response()->json(Chat::find($id));
    }

    public function addMember(Request $request, $chat_id): JsonResponse
    {
        if (!Chat::where('id', $chat_id)) {
            return response()->json(['message' => 'Chat not found'], 404);
        };

        if (!User::where('id', $request->user_id)) {
            return response()->json(['message' => 'User not found'], 404);
        };

        $isExist = ChatUser::where('chat_id', $chat_id)->where('user_id', $request->user_id)->count();

        if ($isExist) {
            return response()->json(['message' => 'User already in the chat'], 409);
        }

        ChatUser::create([
            'user_id' => $request->user_id,
            'role_id' => 2,
            'chat_id' => $chat_id
        ]);

        return response()->json(['message' => 'User added to the chat']);
    }

    public function members($chat_id): JsonResponse
    {
        if (!Chat::where('id', $chat_id)) {
            return response()->json(['message' => 'Chat not found'], 404);
        };

        return response()->json(ChatUser::where('chat_id', $chat_id)->with('user')->get());
    }

    public function getMessages(Request $request, $chat_id): JsonResponse {
        if (!Chat::where('id', $chat_id)) {
            return response()->json(['message' => 'Chat not found'], 404);
        };

        return response()->json(ChatMessage::where('chat_id', $chat_id)->with('user')->get());
    }
}
