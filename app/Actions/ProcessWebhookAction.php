<?php

declare(strict_types=1);

namespace App\Actions;

use App\DTO\WebhookDTO;
use App\Enums\PaymentStatusEnum;
use App\Exceptions\AmountConflictException;
use App\Exceptions\InvalidStatusTransitionException;
use App\Models\Payment;
use DB;
use Illuminate\Database\QueryException;

class ProcessWebhookAction
{
    public function execute(WebhookDTO $data): void
    {
        DB::transaction(static function () use ($data) {

            $payment = Payment::where('payment_id', $data->paymentId)
                ->lockForUpdate()
                ->first();

            if (! $payment) {
                try {

                    Payment::create([
                        'payment_id' => $data->paymentId,
                        'status' => $data->status,
                        'amount' => $data->amount,
                        'event_time' => $data->eventTime,
                    ]);

                    return;

                } catch (QueryException $e) {

                    $payment = Payment::where('payment_id', $data->paymentId)
                        ->lockForUpdate()
                        ->first();
                }
            }

            if ($data->eventTime->lt($payment->event_time)) {
                return;
            }

            if ($payment->status === 'paid' && $payment->amount !== $data->amount) {
                throw new AmountConflictException('Amount mismatch');
            }

            $current = PaymentStatusEnum::from($payment->status);
            $new = PaymentStatusEnum::from($data->status);

            if ($current === $new) {
                return;
            }
            if (! $current->canTransitionTo($new)) {
                throw new InvalidStatusTransitionException('Can not transition to a payment status');
            }

            $payment->update([
                'status' => $data->status,
                'event_time' => $data->eventTime,
                'amount' => $data->amount,
            ]);
        });
    }
}
