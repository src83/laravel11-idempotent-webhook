<?php

declare(strict_types=1);

namespace App\Enums;

enum PaymentStatusEnum: string
{
    case CREATED = 'created';
    case AUTHORIZED = 'authorized';
    case PAID = 'paid';
    case FAILED = 'failed';
    case REFUNDED = 'refunded';

    public function canTransitionTo(self $new): bool
    {
        return in_array($new, match ($this) {
            self::CREATED => [self::AUTHORIZED, self::FAILED],
            self::AUTHORIZED => [self::PAID, self::FAILED],
            self::PAID => [self::REFUNDED],
            self::FAILED => [],
            self::REFUNDED => [],
        }, true);
    }
}
