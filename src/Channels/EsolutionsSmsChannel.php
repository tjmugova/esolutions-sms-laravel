<?php

namespace Tjmugova\EsolutionsSms\Channels;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Notifications\Events\NotificationFailed;
use Illuminate\Notifications\Notification;
use Tjmugova\EsolutionsSms\EsolutionsSms;
use Tjmugova\EsolutionsSms\Events\EsolutionsSmsSent;
use Tjmugova\EsolutionsSms\Exceptions\CouldNotSendNotification;
use Tjmugova\EsolutionsSms\Messages\EsolutionsSmsMessage;

class EsolutionsSmsChannel
{
    /**
     * The Bluedot client instance.
     *
     * @var EsolutionsSms
     */
    protected $client;
    protected $from;
    /**
     * @var Dispatcher
     */
    protected $events;

    public function __construct(EsolutionsSms $client, $from, Dispatcher $events)
    {
        $this->client = $client;
        $this->from = $from;
        $this->events = $events;
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     * @return \Vonage\Message\Message
     */
    public function send($notifiable, Notification $notification)
    {
        $to = $this->getTo($notifiable, $notification);
        $recipients = is_array($to) ? $to : [$to];
        foreach ($recipients as $recipient) {
            $message = $notification->toEsolutionsSms($notifiable);

            if (is_string($message)) {
                $message = new EsolutionsSmsMessage($message);
            }
            $payload = [
                'type' => $message->type,
                'from' => $message->from ?: $this->from,
                'to' => $recipient,
                'text' => trim($message->content),
            ];
            try {
                $response = $this->client->sendMessage($payload);
                //if ($response['status'] === 'F') {
                //    throw CouldNotSendNotification::messageRejected($response['remarks']);
                //}
                event(new EsolutionsSmsSent($response));
            } catch (\Exception $exception) {
                $event = new NotificationFailed(
                    $notifiable,
                    $notification,
                    'esolutionsSms',
                    ['message' => $exception->getMessage(), 'exception' => $exception]
                );

                $this->events->dispatch($event);
            }

        }

    }

    /**
     * Get the address to send a notification to.
     *
     * @param mixed $notifiable
     * @param Notification|null $notification
     *
     * @return mixed
     * @throws CouldNotSendNotification
     */
    protected function getTo($notifiable, $notification = null)
    {
        if ($notifiable->routeNotificationFor(self::class, $notification)) {
            return $notifiable->routeNotificationFor(self::class, $notification);
        }
        if ($notifiable->routeNotificationFor('esolutionsSms', $notification)) {
            return $notifiable->routeNotificationFor('esolutionsSms', $notification);
        }
        if (isset($notifiable->phone_number)) {
            return $notifiable->phone_number;
        }
        if (isset($notifiable->mobile)) {
            return $notifiable->mobile;
        }

        throw CouldNotSendNotification::invalidReceiver();
    }
}