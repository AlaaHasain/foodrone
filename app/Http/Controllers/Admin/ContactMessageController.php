<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Reply;

class ContactMessageController extends Controller
{
    public function index()
    {
        // Get messages with unread flag
        $messages = ContactMessage::latest()->paginate(10);
        return view('admin.contact-messages.index', compact('messages'));
    }

public function show($id)
{
    $message = ContactMessage::findOrFail($id);
    
    $message->replies()
        ->where('sender_type', 'customer')
        ->where('is_read_by_admin', false)
        ->update(['is_read_by_admin' => true]);

    if (!$message->is_read) {
        $message->update(['is_read' => true]);
    }

    // فقط نعيد البيانات هنا
    return view('admin.contact-messages.show', [
        'message' => $message,
        'replies' => $message->replies()->oldest()->get()
    ]);
}

public function reply(Request $request, $id)
{
    $request->validate([
        'reply_content' => 'required|string|max:1000',
    ]);

    $message = ContactMessage::findOrFail($id);

    $reply = Reply::create([
        'contact_message_id' => $message->id,
        'content' => $request->reply_content,
        'sender_type' => 'admin',
    ]);

    // 🟡 أرسل نسخة من الرد إلى الإيميل
    $this->sendReplyEmail($message, $request->reply_content);

    return response()->json([
        'success' => true,
        'reply' => $reply,
    ]);
}



    /**
     * Send reply email to customer
     */
    private function sendReplyEmail($message, $content)
    {
        \Log::info('Sending email to: ' . $message->email);
        Mail::html(
            '<h2 style="color:#333;">Hello ' . e($message->name) . '!</h2>
            <p style="color:#555;">We have replied to your message:</p>
            <blockquote style="border-left:4px solid #ffbe33; margin:10px 0; padding-left:10px; color:#555;">'
            . nl2br(e($content)) .
            '</blockquote>
            <p>If you want to reply to this message, please click the button below:</p>
            <a href="' . url('/contact/reply/' . $message->id) . '" 
               style="background-color:#ffbe33; color:white; padding:10px 20px; border-radius:30px; text-decoration:none; display:inline-block;">
               Reply Now
            </a>
            <p style="margin-top:20px; font-size:12px; color:#aaa;">Thank you!</p>', 
            function ($messageObj) use ($message) {
                $messageObj->to($message->email)
                           ->subject('Reply to Your Message');
            }

        );
    }

public function fetch(Request $request)
{
    $messages = ContactMessage::latest()->paginate(10);

    return response()->json([
        'html' => view('admin.contact-messages.partials.list', compact('messages'))->render(),
        'pagination' => [
            'current_page' => $messages->currentPage(),
            'last_page' => $messages->lastPage()
        ]
    ]);
}


    /**
     * Check for new replies (for AJAX polling)
     */
public function checkReplies(Request $request, $id)
{
    $lastId = $request->input('last_id', 0);
    $message = ContactMessage::findOrFail($id);

    $replies = $message->replies()
                       ->where('id', '>', $lastId)
                       ->get();

    return response()->json([
        'replies' => $replies
    ]);
}


    /**
     * Get count of unread messages (for notifications)
     */
    public function unreadCount()
    {
        $count = ContactMessage::where('is_read', false)->count();
        
        return response()->json([
            'count' => $count
        ]);
    }

    public function destroy(ContactMessage $contactMessage)
    {
        $contactMessage->delete();
        return redirect()->route('admin.contact-messages.index')->with('success', 'Message deleted.');
    }
}