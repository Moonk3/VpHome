<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Mail\ContactReply;
use Illuminate\Support\Facades\Mail;
class ContactController extends Controller
{
    public function index(Request $request)
    {
        // dd('entered index');
        try {
            $contacts = Contact::latest()->paginate(10);
            $template = 'backend.contacts.index';
            $config = [
                'seo' => [
                    'index' => [
                        'title' => 'Quản lý liên hệ',
                        'table' => 'Danh sách liên hệ'
                    ]
                ],
                'model' => 'Contact'
            ];

            return view('backend.dashboard.layout', compact(
                'template',
                'config',
                'contacts'
            ));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function showReplyForm($id)
{
    $contact = Contact::findOrFail($id);
    $template = 'backend.contacts.reply';
    $config['seo'] = ['title' => 'Phản hồi liên hệ'];
    return view('backend.dashboard.layout', compact('contact', 'template', 'config'));
}

public function sendReply(Request $request, $id)
{
    $contact = Contact::findOrFail($id);

    $request->validate([
        'reply_message' => 'required|string'
    ]);

    // Gửi mail
    \Mail::to($contact->email)->send(new \App\Mail\ContactReply($contact, $request->reply_message));

    // Cập nhật trạng thái
    $contact->is_replied = true;
    $contact->reply_message = $request->reply_message;
    $contact->save();

    return redirect()->route('contacts.index')->with('success', 'Đã phản hồi thành công!');
}
}
