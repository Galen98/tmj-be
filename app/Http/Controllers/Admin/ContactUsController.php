<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyContactUsRequest;
use App\Models\ContactUs;
use App\Services\ContactUs\ContactUsService;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function __construct(
        private ContactUsService $service
    ) {
    }


    /*
     * =========================================
     * LIST
     * =========================================
     */

    public function index(Request $request)
    {
        $contacts =
            $this->service
                ->getPaginated(
                    $request->get('search')
                );

        return view(
            'dashboard.contact-us.index',
            compact('contacts')
        );
    }


    /*
     * =========================================
     * DETAIL
     * =========================================
     */

    public function show(
        ContactUs $contact
    ) {

        $contact =
            $this->service
                ->markAsRead(
                    $contact
                );


        $contact->load(
            'replies'
        );


        return view(
            'dashboard.contact-us.show',
            compact(
                'contact'
            )
        );
    }


    /*
     * =========================================
     * REPLY
     * =========================================
     */

    public function reply(
        ReplyContactUsRequest $request,
        ContactUs $contact
    ) {

        $this->service
            ->reply(
                $contact,
                $request->validated()[
                    'message'
                ]
            );


        return redirect()
            ->route(
                'admin.contact-us.show',
                $contact
            )
            ->with(
                'success',
                'Balasan berhasil dikirim.'
            );
    }
}
