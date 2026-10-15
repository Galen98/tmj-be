<?php

namespace App\Services\Message;

use App\DTO\Message\PersonalMessageDTO;
use App\Services\BaseService;
use App\Repositories\Message\PersonalMessageRepository;

class PersonalMessageService extends BaseService
{
    protected PersonalMessageRepository $personalMessageRepository;

    public function __construct(PersonalMessageRepository $personalMessageRepository)
    {
        $this->personalMessageRepository = $personalMessageRepository;
    }

    public function sendMessage($data)
    {
        return $this->personalMessageRepository->send($data);
    }

    public function getAllMessages()
    {
        $messages = $this->personalMessageRepository->getAllMessages();
        return $messages->map(function ($item) {
            return (new PersonalMessageDTO(
                $item->name,
                $item->email,
                $item->message,
                $item->is_admin
            ))->toArray();
        });
    }

    public function getMessageById($id)
    {
        $message = $this->personalMessageRepository->getMessageById($id);
        return $message->map(function ($item) {
            return (new PersonalMessageDTO(
                $item->name,
                $item->email,
                $item->message,
                $item->is_admin
            ))->toArray();
        });
    }

    public function deleteMessage($id)
    {
        return $this->personalMessageRepository->deleteMessage($id);
    }
}
