<?php

namespace App\Http\Controllers;

use App\Events\NewMessageAdded;
use App\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function getIndex()
    {
        $messages = Message::all();
        return view('chat.index', compact('messages'));
    }
    public function setMessage(Request $request)
    {
        $data = $request->all();
        $messages = Message::create($data);

        event(
            new NewMessageAdded($messages)
        );
//        return response()->json(Message::all()->toArray());
        return ;
    }
}
