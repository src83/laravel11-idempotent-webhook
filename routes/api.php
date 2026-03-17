<?php

use App\Http\Controllers\Api\PaymentWebhookController;

Route::post('/webhooks/payment', [PaymentWebhookController::class, 'handle']);
