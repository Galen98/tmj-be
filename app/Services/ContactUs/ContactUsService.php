<?php

namespace App\Services\ContactUs;

use App\Jobs\SendContactUsReceivedEmail;
use App\Jobs\SendContactUsReplyEmail;
use App\Models\ContactUs;
use App\Repositories\ContactUs\ContactUsRepository;

class ContactUsService
{
    public function __construct(
        private ContactUsRepository $repository
    ) {
    }


    /*
     * =========================================
     * CREATE CONTACT
     * =========================================
     */

    public function create(
        array $data
    ): ContactUs {

        $contact =
            $this->repository
                ->create([
                    'name' =>
                        $data['name'],

                    'email' =>
                        $data['email'],

                    'message' =>
                        $data['message'],

                    'is_read' =>
                        false,
                ]);


        /*
         * Queue confirmation email
         */

        SendContactUsReceivedEmail::dispatch(
            $contact->id
        );


        return $contact;
    }


    /*
     * =========================================
     * GET PAGINATED
     * =========================================
     */

    public function getPaginated(
        ?string $search = null
    ) {

        return $this->repository
            ->getPaginated(
                $search
            );
    }


    /*
     * =========================================
     * MARK AS READ
     * =========================================
     */

    public function markAsRead(
        ContactUs $contact
    ): ContactUs {

        return $this->repository
            ->markAsRead(
                $contact
            );
    }


    /*
     * =========================================
     * ADMIN REPLY
     * =========================================
     */

    public function reply(
        ContactUs $contact,
        string $message
    ) {

        /*
         * Save reply
         */

        $reply =
            $this->repository
                ->createReply(
                    $contact,
                    $message
                );


        /*
         * Queue reply email
         */

        SendContactUsReplyEmail::dispatch(
            $contact->id,
            $reply->id
        );


        return $reply;
    }
}
