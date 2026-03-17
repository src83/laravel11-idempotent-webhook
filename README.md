## Laravel 11 idempotent webhook

- Version: v11.48.0
- PHP: 8.2.30

#### Install
- `git clone git@github.com:src83/laravel11-idempotent-webhook.git`
- append and confirurate `.env`
- `composer update`
- `php artisan migrate`
- `php artisan db:seed`
- `php artisan ide-helper:models`
- Try API: POST `http://l11webhook.loc/api/webhooks/payment`
- Request body:
```json
{
  "payment_id": "pay_123",
  "status": "paid",
  "amount": 1000,
  "event_time": "2026-02-20T10:15:00Z"
}

