<?php

namespace App\Http\Controllers\Api;

use App\Actions\ProcessWebhookAction;
use App\DTO\WebhookDTO;
use App\Exceptions\AmountConflictException;
use App\Exceptions\InvalidStatusTransitionException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PaymentRequest;
use Illuminate\Http\JsonResponse;

class PaymentWebhookController extends Controller
{
    public function __construct(
        public ProcessWebhookAction $action
    ) {}

    /**
     * Accept and handle a newly created webhook in storage
     */
    public function handle(PaymentRequest $request): JsonResponse
    {
        $requestData = $request->validated();

        $requestDto = WebhookDTO::fromRequest($requestData);

        try {
            $this->action->execute($requestDto);

            return response()->json(
                ['success' => true, 'http_code' => 200, 'http_text' => 'OK'],
                200
            );

        } catch (AmountConflictException $e) {

            return response()->json(
                ['success' => false, 'http_code' => 409, 'http_text' => 'Conflict'],
                409
            );

        } catch (InvalidStatusTransitionException $e) {

            return response()->json(
                ['success' => false, 'http_code' => 422, 'http_text' => 'Unprocessable Entity'],
                422
            );
        }
    }
}
