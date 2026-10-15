<?php

namespace App\Repositories\Chat;

use App\Interfaces\Chat\ChatInterface;

class ChatRepository implements ChatInterface
{
    public function sendChatConv($data)
    {
        // Logic to send a chat conversation
    }

    public function getAllChatList($userToken)
    {
        // Logic to retrieve all chat conversations for a user
    }

    public function getChatConvProduct($session, $userToken)
    {
        // Logic to retrieve a specific chat conversation by session for a user
    }

    public function checkChatConvProduct($travelId, $userToken)
    {
        // Logic to check if a chat conversation exists for a specific travel item and user
    }

    public function validatedExpiredUserToken($userToken)
    {
        // Logic to validate if a user token is expired
    }

    public function addSessionUserToken($data)
    {
        // Logic to add a session user token
    }

    public function getUserData($userToken)
    {
        // Logic to retrieve user data based on the user token
    }
}
