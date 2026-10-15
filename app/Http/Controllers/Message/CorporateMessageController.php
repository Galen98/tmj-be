<?php

namespace App\Http\Controllers\Message;

use App\Http\Controllers\Controller;
use App\Http\Requests\Message\CorporateMessageRequest;
use App\Http\Traits\TraitsResponse;
use App\Services\Message\CorporateMessageService;

class CorporateMessageController extends Controller
{
   use TraitsResponse;

   protected CorporateMessageService $corporateMessageService;

   public function __construct(CorporateMessageService $corporateMessageService)
   {
        $this->corporateMessageService = $corporateMessageService;
   }

   public function sendCorporateMessage(CorporateMessageRequest $request)
   {
        try {
            $data = $request->validated();
            $this->corporateMessageService->sendCorporateMessage($data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Failed to send corporate message');
        }
        return $this->successResponse(null, 'Corporate message sent successfully');
   }

   public function getCorporateMessages()
   {
        try {
            $messages = $this->corporateMessageService->getAllCorporateMessages();
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Failed to retrieve corporate messages');
        }
        return $this->successResponse($messages, 'Corporate messages retrieved successfully');
   }

    public function getCorporateMessageById($id)
    {
        try {
            $message = $this->corporateMessageService->getCorporateMessage($id);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Failed to retrieve corporate message');
        }
        return $this->successResponse($message, 'Corporate message retrieved successfully');
    }

    public function deleteCorporateMessage($id)
    {
        try {
            $this->corporateMessageService->deleteCorporateMessage($id);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), 'Failed to delete corporate message');
        }
        return $this->successResponse(null, 'Corporate message deleted successfully');
    }
}
