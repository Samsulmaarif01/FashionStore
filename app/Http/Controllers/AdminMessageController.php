<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminMessageController extends Controller
{
    public function index()
    {
        $messages = \App\Models\Message::latest()->paginate(10);
        return view('admin.messages', compact('messages'));
    }

    public function destroy(\App\Models\Message $message)
    {
        $message->delete();
        return back()->with('success', 'Pesan berhasil dihapus.');
    }
}
