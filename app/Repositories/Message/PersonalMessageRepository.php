<?php

namespace App\Repositories\Message;

use App\Interfaces\Message\PersonalMessageInterface;
use App\Models\Message\PersonalMessageModel;

class PersonalMessageRepository implements PersonalMessageInterface
{
    public function send($data)
    {
        return PersonalMessageModel::create($data);
    }

    public function getAllMessages()
    {
        return PersonalMessageModel::all();
    }

    public function getMessageById($id)
    {
        return PersonalMessageModel::find($id);
    }

    public function deleteMessage($id)
    {
        $message = PersonalMessageModel::find($id);
        if ($message) {
            return $message->delete();
        }
        return false;
    }
}
