<?php

namespace App\Providers;

use Illuminate\Mail\Events\MessageSending;
use Illuminate\Mail\Events\MessageSent;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Centralized mail lifecycle logging to help debug delivery issues.
        app('events')->listen(MessageSending::class, function (MessageSending $event): void {
            Log::info('mail_sending', [
                'to' => $this->messageAddresses($event->message->getTo()),
                'subject' => $event->message->getSubject(),
            ]);
        });

        app('events')->listen(MessageSent::class, function (MessageSent $event): void {
            $message = $event->sent->getOriginalMessage();

            Log::info('mail_sent', [
                'to' => $this->messageAddresses($message->getTo()),
                'subject' => $message->getSubject(),
                'message_id' => $this->normalizeMessageId($event->sent->getMessageId()),
            ]);
        });
    }

    private function messageAddresses(?array $addresses): array
    {
        if (empty($addresses)) {
            return [];
        }

        return collect($addresses)
            ->map(fn ($address) => method_exists($address, 'toString') ? $address->toString() : (string) $address)
            ->values()
            ->all();
    }

    private function normalizeMessageId(?string $messageId): ?string
    {
        if ($messageId === null) {
            return null;
        }

        return Str::of($messageId)->trim('<>')->toString();
    }
}
