<?php

declare(strict_types=1);

namespace App\DTO;

use Illuminate\Support\Carbon;

class WebhookDTO
{
    public function __construct(
        public string $paymentId,
        public string $status,
        public int $amount,
        public Carbon $eventTime
    ) {}

    public static function fromRequest(array $requestData): self
    {
        return new self(
            paymentId: (string) $requestData['payment_id'],
            status: (string) $requestData['status'],
            amount: (int) $requestData['amount'],
            eventTime: Carbon::parse($requestData['event_time'])->utc(),
        );
    }
}
