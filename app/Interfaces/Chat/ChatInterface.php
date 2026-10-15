<?php

namespace App\Interfaces\Chat;

interface ChatInterface
{
    public function sendChatConv($data);
    public function getAllChatList($userToken);
    public function getChatConvProduct($session, $userToken);
    public function checkChatConvProduct($travelId, $userToken);
    public function validatedExpiredUserToken($userToken);
    public function addSessionUserToken($data);
    public function getUserData($userToken);
}

