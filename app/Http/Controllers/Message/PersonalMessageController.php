<?php

namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;
use App\Http\Requests\Message\PersonalMessageRequest;
use App\Http\Traits\TraitsResponse;
use App\Mail\PersonalMessageMail;
use App\Services\Message\PersonalMessageService;
use Illuminate\Support\Facades\Mail;

class PersonalMessageController extends Controller
{
   use TraitsResponse;

   protected PersonalMessageService $personalMessageService;

   public function __construct(PersonalMessageService $personalMessageService)
   {
        $this->personalMessageService = $personalMessageService;
   }

   public function sendPersonalMessage(PersonalMessageRequest $request)
   {
        try {
            $data = $request->validated();
            $this->personalMessageService->sendMessage($data);

        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Failed to send personal message');
        }

            return $this->successResponse(null, 'Personal message sent successfully');
   }

   public function adminSendPersonalMessage(PersonalMessageRequest $request, $id)
    {
        try {
            $data = $request->validated();
            $data['is_admin'] = true;

            $messageData = $this->personalMessageService->getMessageById($id);

            $adminMessage = $data['message'];

            $this->personalMessageService->sendMessage($data);

            Mail::to($messageData->user->email)
                ->send(new PersonalMessageMail($messageData, $adminMessage));

        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Failed to send personal message');
        }

        return $this->successResponse(null, 'Personal message sent successfully');
    }

    public  function getPersonalMessages()
    {
        try {
            $messages = $this->personalMessageService->getAllMessages();

        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Failed to retrieve personal messages');
        }

        return $this->successResponse($messages, 'Personal messages retrieved successfully');
    }

    public function getPersonalMessagesById($id)
    {
        try {
            $message = $this->personalMessageService->getMessageById($id);

        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Failed to retrieve personal message');
        }

        return $this->successResponse($message, 'Personal message retrieved successfully');
    }

    public function deletePersonalMessage($id)
    {
        try {
            $this->personalMessageService->deleteMessage($id);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Failed to delete personal message');
        }
        return $this->successResponse(null, 'Personal message deleted successfully');
    }
}
