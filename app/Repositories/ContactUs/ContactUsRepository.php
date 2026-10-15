<?php

namespace App\Repositories\ContactUs;

use App\Models\ContactUs;
use App\Models\ContactUsReply;

class ContactUsRepository
{
    public function create(
        array $data
    ): ContactUs {

        return ContactUs::create(
            $data
        );
    }


    public function getPaginated(
    ?string $search = null
    ) {
        return ContactUs::query()

            ->when(
                $search,
                function ($query) use ($search) {

                    $query->where(
                        function ($query) use ($search) {

                            $query
                                ->where(
                                    'name',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'email',
                                    'like',
                                    "%{$search}%"
                                )
                                ->orWhere(
                                    'message',
                                    'like',
                                    "%{$search}%"
                                );

                        }
                    );

                }
            )

            // unread di atas
            ->orderBy(
                'is_read',
                'asc'
            )

            // yang terbaru di atas
            ->orderByDesc(
                'created_at'
            )

            ->paginate(10);
    }


    public function markAsRead(
        ContactUs $contact
    ): ContactUs {

        if (!$contact->is_read) {

            $contact->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }


        return $contact;
    }


    public function createReply(
        ContactUs $contact,
        string $message
    ): ContactUsReply {

        return $contact
            ->replies()
            ->create([
                'message' => $message,
                'sent_at' => now(),
            ]);
    }
}
