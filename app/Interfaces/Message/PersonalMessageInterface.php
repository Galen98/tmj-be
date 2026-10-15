<?php

namespace App\Interfaces\Message;

interface PersonalMessageInterface
{
    // Define the methods that the PersonalMessageModel must implement
    public function send($data);
    public function getAllMessages();
    public function getMessageById($id);
    public function deleteMessage($id);
}
