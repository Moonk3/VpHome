<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\FrontendController;
use Illuminate\Http\Request;
use App\Models\Contact;
// use App\Services\Interfaces\ContactServiceInterface as ContactService;
// use App\Repositories\Interfaces\ContactRepositoryInterface as ContactRepository;


class ContactController extends FrontendController
{
    protected $language;
    protected $system;
    // protected $contactService;
    // protected $contactRepository;

    public function __construct(
        // ContactService $contactService,
        // ContactRepository $contactRepository,
    ){
        // $this->ContactService = $contactService;
        // $this->ContactRepository = $contactRepository;
        parent::__construct(); 
    }


    public function index(Request $request){
       
       
        $config = $this->config();
        $system = $this->system;
        $seo = [
            'meta_title' => 'Trang Thông tin liên hệ',
            'meta_description' => 'Thông tin liên hệ của '.$system['homepage_company'],
            'meta_keyword' => '',
            'meta_image' => '',
            'canonical' => write_url('lien-he')
        ];
        return view('frontend.contact.index', compact(
            'config',
            'seo',
            'system',
        ));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);
    
        Contact::create($validated);
    
        return back()->with('success', 'Cảm ơn bạn đã liên hệ. Chúng tôi sẽ phản hồi sớm nhất!');
    }
    private function config(){
        return [
            'language' => $this->language,
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'js' => [
                'backend/library/location.js',
                'frontend/core/library/cart.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            ]
        ];
    }

}
