<?php

namespace App\Interfaces\Message;

interface CorporateMessageInterface
{
    // Define the methods that the CorporateMessageModel must implement
    public function send($data);
    public function getAllMessages();
    public function getMessageById($id);
    public function deleteMessage($id);
}
