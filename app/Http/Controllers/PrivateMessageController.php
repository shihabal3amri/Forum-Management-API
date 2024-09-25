<?php

namespace App\Http\Controllers;

use App\Models\PrivateMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrivateMessageController extends Controller
{
    // Get all messages that were sent and received by the authenticated user, with pagination
    public function getMessagesForUser(Request $request)
    {
        $user = Auth::user(); // Get the authenticated user

        // Fetch messages where the user is either the sender or receiver
        $messages = PrivateMessage::where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->with(['sender', 'receiver'])
            ->paginate(10); // Paginate 10 messages per page

        return response()->json($messages);
    }
}


