<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

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
}
