<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use App\Models\Reply;

class ContactReplyController extends Controller
{
    // عرض فورم الرد للعميل
    public function showReplyForm($id)
    {
        $message = ContactMessage::findOrFail($id);
        return view('contact.reply', compact('message'));
    }

    // حفظ رد العميل
    public function submitReply(Request $request, $id)
    {
        $request->validate([
            'reply_content' => 'required|string|max:1000',
        ]);
    
        $message = ContactMessage::findOrFail($id);
    
        $reply = Reply::create([
            'contact_message_id' => $message->id,
            'content' => $request->reply_content,
            'sender_type' => 'customer',
            'is_read_by_admin' => false, // ✅ هذا هو اللي يخلينا نعرف إنها جديدة
        ]);
    
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Reply sent successfully',
                'reply' => $reply
            ]);
        }
    
        return redirect('/')->with('success', 'Your reply has been sent successfully!');
    }
    
    
    // جلب الردود الجديدة
    public function fetchNewReplies(Request $request, $id)
    {
        $message = ContactMessage::findOrFail($id);
        $lastReplyId = $request->input('last_reply_id', 0);
        
        $newReplies = Reply::where('contact_message_id', $message->id)
                          ->where('id', '>', $lastReplyId)
                          ->orderBy('created_at', 'asc')
                          ->get();
        
        return response()->json([
            'success' => true,
            'replies' => $newReplies
        ]);
    }
}