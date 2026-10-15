<?php

namespace App\Services\Message;

use App\DTO\Message\CorporateMessageDTO;
use App\Repositories\Message\CorporateMessageRepository;
use App\Services\BaseService;

class CorporateMessageService extends BaseService
{
    protected CorporateMessageRepository $corporateMessageRepository;

    public function __construct(CorporateMessageRepository $corporateMessageRepository)
    {
        $this->corporateMessageRepository = $corporateMessageRepository;
    }

    public function sendCorporateMessage($data)
    {
        return $this->corporateMessageRepository->send($data);
    }

    public function getAllCorporateMessages()
    {
        $messages = $this->corporateMessageRepository->getAllMessages();
        return $messages->map(function ($item){
            return (new CorporateMessageDTO(
                $item->corporate_name,
                $item->corporate_contact,
                $item->hari_acara,
                $item->jumlah_peserta,
                $item->add_hotel,
                $item->lokasi_start
            ))->toArray();
        });
    }

    public function getCorporateMessage($id)
    {
        $message = $this->corporateMessageRepository->getMessageById($id);
        return $message->map(function ($item){
            return (new CorporateMessageDTO(
                $item->corporate_name,
                $item->corporate_contact,
                $item->hari_acara,
                $item->jumlah_peserta,
                $item->add_hotel,
                $item->lokasi_start
            ))->toArray();
        });
    }

    public function deleteCorporateMessage($id)
    {
        return $this->corporateMessageRepository->deleteMessage($id);
    }
}
